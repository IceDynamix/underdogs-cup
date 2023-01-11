const {Client, Events, GatewayIntentBits} = require('discord.js');

const token = process.env.DISCORD_TOKEN;
const guildId = process.env.DISCORD_GUILD_ID;
const clientId = process.env.DISCORD_CLIENT_ID;
const roleId = process.env.DISCORD_ROLE_ID;
const channelId = process.env.DISCORD_LOG_CHANNEL_ID;

const inviteUrl = [
    `https://discord.com/api/oauth2/authorize?client_id=${clientId}`,
    "permissions=402655232", // manage roles, manage nicknames, send messages
    "scope=guilds%20bot",
    `guild_id=${guildId}`,
    "disable_guild_select=true"
].join("&");

const bot = new Client({intents: [GatewayIntentBits.Guilds, GatewayIntentBits.GuildMembers]});

bot.once(Events.ClientReady, c => {
    if (!c.guilds.cache.has(guildId)) {
        console.error(`Bot not in specified guild, please invite the bot with this url: ${inviteUrl}`);
        process.exit(-1);
    }

    console.log(`Ready! Logged in as ${c.user.tag}`);
});

const login = async () => await bot.login(token);

const orThrow = (thing, msg) => {
    if (thing) return thing;
    throw new Error(msg);
};

const guild = () => orThrow(bot.guilds.cache.get(guildId), "Guild not found");
const channel = () => orThrow(guild().channels.cache.get(channelId), "Channel not found");
const member = async (id) => orThrow(await guild().members.fetch(id), "Member not found");

const setNickname = async (userId, nickname) => (await member(userId)).setNickname(nickname, 'Registration')
    .catch(() => log("Failed to change nickname"));
const giveRole = async userId => (await member(userId)).roles.add(roleId)
    .catch(() => log("Failed to add role"));
const takeRole = async userId => (await member(userId)).roles.remove(roleId)
    .catch(() => log("Failed to take role"));

const log = async msg => {
    await channel().send(msg);
    console.log(`Logged message: ${msg}`);
}

const dm = async (id, msg) => {
    try {
        await bot.users.send(id, msg);
        console.log(`Sent message to user ${id}: ${msg}`);
    } catch (err) {
        console.log(`Failed to send message to user ${id}`);
    }
}

module.exports = {bot, setNickname, giveRole, takeRole, log, guild, login, dm};
