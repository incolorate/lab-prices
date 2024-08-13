// MainHarvester.js
const yargs = require("yargs/yargs");
const { hideBin } = require("yargs/helpers");
const argv = yargs(hideBin(process.argv)).argv;

module.exports = {
    defaultValues: {
        goBack: true,
        forceScroll: false,
    },
    vacancyCount: {
        success: 0,
        error: 0,
    },
    browserConfig: {
        slowMo: 100,
        width: parseInt(process.env.WIDTH),
        height: parseInt(process.env.HEIGHT),
        headless: process.env.DEBUG === "false" ? "new" : false,
    },
    url: "",
    limit: argv.limit || 10,
    offset: 0,
    DEBUG: false,
    sendInBatches: true,
};
