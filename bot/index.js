require('dotenv').config();

const fastify = require('fastify')({logger: true});
const port = process.env.DISCORD_BOT_PORT;

fastify.post('/registered', (req, res) => {
    return req.body;
});

fastify.post('/unregistered', (req, res) => {
    return req.body;
});

fastify.listen({port}, (err, addr) => {
    if (err) throw err;
})
