const {createClient} = require('redis');

const appName = process.env.APP_NAME;
const prefix = `${appName.toLowerCase().replaceAll(" ", "_")}_database_`;

const host = process.env.REDIS_HOST;
const password = process.env.REDIS_PASSWORD;
const port = process.env.REDIS_PORT;

const redisOptions = {socket: {host, port}};
if (password && password !== "null") redisOptions.password = password;

const redis = createClient(redisOptions);

const key = (k) => prefix + k;

async function subscribe(channel, fn) {
    const ch = key(channel);
    const sub = redis.duplicate();
    await sub.connect();
    await sub.subscribe(ch, fn);
    console.log(`Subscribed to ${ch}`);
}

module.exports = {redis, subscribe, key};
