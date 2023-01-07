const {Client, Events, GatewayIntentBits} = require('discord.js');

const token = process.env.DISCORD_TOKEN;
const guild = process.env.DISCORD_GUILD_ID;
const client = process.env.DISCORD_CLIENT_ID;

const inviteUrl = [`https://discord.com/api/oauth2/authorize?client_id=${client}`, "permissions=335544320", "scope=guilds%20bot", `guild_id=${guild}`, "disable_guild_select=true"].join("&");

const bot = new Client({intents: [GatewayIntentBits.Guilds]});

bot.once(Events.ClientReady, c => {
    if (c.guilds.cache.find(g => g.id === guild) === undefined) {
        console.error(`Bot not in specified guild, please invite the bot with this url: ${inviteUrl}`);
        process.exit(-1);
    }

    console.log(`Ready! Logged in as ${c.user.tag}`);
});

bot.login(token);

module.exports = {bot};
