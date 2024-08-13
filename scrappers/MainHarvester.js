import puppeteer from "puppeteer";
import axios from axios

class MainHarvester {
    constructor() {
        this.width = 1920;
        this.height = 1080;
    }

    async initialize() {
        let browser;
        try {
            browser = await puppeteer.launch({
                headless: false,
                args: [
                    "--disable-gpu",
                    "--no-sandbox",
                    "--disable-dev-shm-usage",
                    "--disable-setuid-sandbox",
                    "--no-zygote",
                    `--window-size=${this.width},${this.height}`,
                ],
            });
            this.page = await browser.newPage();
        } catch (error) {
            console.error("Error initializing the browser", error);
        }
    }

    async navigateToLink(link) {
        try {
            const response = await this.page.goto(link, {
                waitUntil: "networkidle0",
            });

            if (response) {
                console.log(
                    `Page: ${link} loaded  with status ${response.status()}`
                );
            } else {
                console.log(`Page: ${link} loaded`);
            }
        } catch (err) {
            console.error("Error navigating to link", err);
        }
    }

    async startJob() {
        try {
            await this.initialize();
            await this.navigateToLink(this.link);
            await this.harvestData();
        } catch (error) {
            console.error("Error starting the job", error);
        }
    }

    async sendDataToApi () {
        try {
            const response = await axios.post("http://localhost:3000/api/price-list", {
                data: this.data,
            });

            console.log("Data sent to API", response.data);
        } catch (error) {
            console.error("Error sending data to API", error);
        }
    }
}

export default MainHarvester;
