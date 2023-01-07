require('dotenv').config();

const discord = require("./discord");

const fastify = require('fastify')({logger: true});
const port = process.env.DISCORD_BOT_PORT;

fastify.post('/registered', async (req, res) => {
    const {user, tournament} = req.body;
    try {
        await discord.setNickname(user.id, username);
        await discord.giveRole(user.id);
        return {ok: true};
    } catch (err) {
        console.error(err);
        return {ok: false, err};
    }
});

fastify.post('/unregistered', async (req, res) => {
    const {user, tournament} = req.body;
    try {
        await discord.takeRole(user.id);
        return {ok: true};
    } catch (err) {
        console.error(err);
        return {ok: false, err};
    }
});

fastify.listen({port}, (err, addr) => {
    if (err) throw err;
})
