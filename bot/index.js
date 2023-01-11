require('dotenv').config();

const discord = require("./discord");
const redis = require("./redis");

redis.subscribe("register", async function (msg) {
    const {user, tournament} = JSON.parse(msg);
    const username = user.tetrio.username;
    try {
        await discord.log(`:green_square: | User <@${user.id}>  \`${username}\` registered for tournament ${tournament.name}`);
        await discord.setNickname(user.id, username);
        await discord.giveRole(user.id);
    } catch (err) {
        console.error(err);
    }
});

redis.subscribe("unregister", async function (msg) {
    const {user, tournament} = JSON.parse(msg);
    const username = user.tetrio.username;
    try {
        await discord.log(`:red_square: | User <@${user.id}>  \`${username}\` unregistered from tournament ${tournament.name}`);
        await discord.takeRole(user.id);
    } catch (err) {
        console.error(err);
    }
});
