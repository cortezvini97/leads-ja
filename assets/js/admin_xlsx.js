const download_btn = document.querySelector("#download_btn");

if(download_btn != undefined){
    async function getFile(){
        let url = download_btn.getAttribute("data-url")
        const res = await fetch(url)
        const data = await res.json()
        const data_url = data.data_url
        download_btn.setAttribute("href", data_url)
    }
    getFile()
}
