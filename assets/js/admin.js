import '../css/admin.css'
import '@fortawesome/fontawesome-free/css/all.min.css'
import 'bootstrap/dist/css/bootstrap.min.css'


$('#toogle-click').on('click', function(e)
{
    const checkbox = document.querySelector("#sidebar-toogle");

    if(checkbox.checked === true) 
    {
        checkbox.checked = false;
    }else
    {
        checkbox.checked = true;
    }
})