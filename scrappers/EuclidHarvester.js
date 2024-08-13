import MainHarvester from "./MainHarvester.js";

class EuclidHarvester extends MainHarvester {
    constructor() {
        super();
        this.link = "https://euclidhospital.ro/tarife-analize-de-laborator/";
        this.data = [];
    }

    async harvestData() {
        try {
            this.page.waitForNavigation({ waitUntil: "networkidle0" });

            const data = await this.page.evaluate(() => {
                const table = document.querySelector("table");
                const rows = table.querySelectorAll("tr");
                const data = [];

                rows.forEach((row) => {
                    const columns = row.querySelectorAll("td");
                    if (columns.length > 0) {
                        data.push({
                            name: columns[0] ? columns[0].innerText : "",
                            price: columns[1]
                                ? columns[1].innerText.split(" ")[0]
                                : "",
                            unit: columns[2] ? columns[2].innerText : "",
                        });
                    }
                });

                return data;
            });
            // Push the last object if it exists

            console.log(data);
            this.data = data;
        } catch (error) {
            console.error("Error harvesting data", error);
        }
    }
}

const euclidHarvester = new EuclidHarvester();

euclidHarvester.initialize();
euclidHarvester.startJob();
