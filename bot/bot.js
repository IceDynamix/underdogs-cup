const {Client, Events, GatewayIntentBits} = require('discord.js');

const token = process.env.DISCORD_TOKEN;

export const bot = new Client({intents: [GatewayIntentBits.Guilds]});

bot.once(Events.ClientReady, c => {
    console.log(`Ready! Logged in as ${c.user.tag}`);
});

bot.login(token);
