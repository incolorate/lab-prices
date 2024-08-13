import puppeteer from "puppeteer";

async function setupBrowser(config) {
    const { headless, slowMo, width, height } = config.browserConfig;

    let browser;
    try {
        browser = await puppeteer.launch({
            headless,
            slowMo,
            args: [
                "--disable-gpu",
                "--no-sandbox",
                "--disable-dev-shm-usage",
                "--disable-setuid-sandbox",
                "--no-zygote",
                `--window-size=${width},${height}`,
            ],
            defaultViewport: {
                width,
                height,
            },
        });
        const page = await browser.newPage();
        return { browser, page };
    } catch (err) {
        if (browser) {
            await browser.close();
        }
        console.log(`Error setting up browser: ${err.message}`);
        throw err;
    }
}

async function closeBrowser(browser) {
    if (browser) {
        try {
            await browser.close();
        } catch (err) {
            console.log(`Error closing browser: ${err.message}`);
        }
    }
}

export { setupBrowser, closeBrowser };
