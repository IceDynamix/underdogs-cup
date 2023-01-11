require('dotenv').config();

const discord = require("./discord");
const {Events} = require("discord.js");
const {redis, subscribe, key} = require("./redis");

async function setupSubscribes() {
    await subscribe("register", async function (msg) {
        const {user, tournament} = JSON.parse(msg);
        const username = user.tetrio.username;
        try {
            await discord.log(`:green_square: | User <@${user.id}> \`${username}\` registered for tournament ${tournament.name}`);
            await discord.setNickname(user.id, username);
            await discord.giveRole(user.id);
        } catch (err) {
            console.error(err);
        }
    });

    await subscribe("unregister", async function (msg) {
        const {user, tournament} = JSON.parse(msg);
        const username = user.tetrio.username;
        try {
            await discord.log(`:red_square: | User <@${user.id}> \`${username}\` unregistered from tournament ${tournament.name}`);
            await discord.takeRole(user.id);
        } catch (err) {
            console.error(err);
        }
    });
}


async function setupMemberTracking(setKey) {
    setKey = key(`discord:members`);

    // Synchronize members set on startup by creating the set from scratch
    await redis.del(setKey);
    await redis.executeIsolated(async c => discord.guild()
        .members.cache.each(async m => await c.sAdd(setKey, m.id)));

    const count = await redis.sCard(setKey);
    console.log(`Synchronized Discord members set with ${count} members`);

    discord.bot.on(Events.GuildMemberAdd, async function (m) {
        await redis.sAdd(setKey, m.id);
        console.log(`Stored ${m.id} in Discord members set`);
    });

    console.log("Added member add listener");

    discord.bot.on(Events.GuildMemberRemove, async function (m) {
        await redis.sRem(setKey, m.id);
        console.log(`Removed ${m.id} from Discord members set`);
    });

    console.log("Added member leave listener");
}

async function main() {
    await redis.connect();
    console.log("Connected to Redis");

    await discord.login();

    await setupSubscribes();
    console.log("Finished setting up subscribes");

    await setupMemberTracking("discord:members")
    console.log("Finished setting up member set");
}

main().catch(console.error);
