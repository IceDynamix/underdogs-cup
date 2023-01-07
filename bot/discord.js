const {Client, Events, GatewayIntentBits} = require('discord.js');

const token = process.env.DISCORD_TOKEN;
const guildId = process.env.DISCORD_GUILD_ID;
const clientId = process.env.DISCORD_CLIENT_ID;
const roleId = process.env.DISCORD_ROLE_ID;

const inviteUrl = [`https://discord.com/api/oauth2/authorize?client_id=${clientId}`, "permissions=335544320", "scope=guilds%20bot", `guild_id=${guildId}`, "disable_guild_select=true"].join("&");

const bot = new Client({intents: [GatewayIntentBits.Guilds]});

bot.once(Events.ClientReady, c => {
    if (!c.guilds.cache.has(guildId)) {
        console.error(`Bot not in specified guild, please invite the bot with this url: ${inviteUrl}`);
        process.exit(-1);
    }

    console.log(`Ready! Logged in as ${c.user.tag}`);
});

bot.login(token);

const orThrow = (thing, msg) => {
    if (thing) return thing;
    throw new Error(msg);
};

const guild = () => orThrow(bot.guilds.cache.get(guildId), "Guild not found");
const member = async (id) => orThrow(await guild().members.fetch(id), "Member not found");

const setNickname = async (userId, nickname) => (await member(userId)).setNickname(nickname, 'Registration');
const giveRole = async userId => (await member(userId)).roles.add(roleId);
const takeRole = async userId => (await member(userId)).roles.remove(roleId);

module.exports = {bot, setNickname, giveRole, takeRole};