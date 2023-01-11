const {createClient} = require('redis');

const appName = process.env.APP_NAME;

const host = process.env.REDIS_HOST;
const password = process.env.REDIS_PASSWORD;
const port = process.env.REDIS_PORT;

const redisOptions = {socket: {host, port}};
if (password && password !== "null") redisOptions.password = password;

const client = createClient(redisOptions);

async function subscribe(channel, fn) {
    const appNameSlug = appName.toLowerCase().replaceAll(" ", "_");
    const channelId = `${appNameSlug}_database_${channel}`;
    const sub = client.duplicate();
    await sub.connect();
    await sub.subscribe(channelId, fn);
    console.log(`Subscribed to ${channel}`);
}

module.exports = {client, subscribe};
