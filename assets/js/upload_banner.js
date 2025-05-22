var inputFile = document.querySelector("#input-file")
var imageView = document.querySelector("#image-view")

if(inputFile != undefined){
    inputFile.addEventListener("change", function(e){
        let file = e.target.files[0]
        console.log(file)
        let reader = new FileReader()
        reader.onload = function(even){
            let result = even.target.result
            imageView.src = result
        }
        reader.readAsDataURL(file)
    })
}