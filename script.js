document.addEventListener("DOMContentLoaded", function () {
    let delete_btn = document.querySelectorAll(".remove");
    let close_btn = document.querySelectorAll(".close");
    let modify_btn = document.querySelectorAll(".changeTo");
    console.log(modify_btn)
    modify_btn.forEach(btn => {
        btn.addEventListener("click", function() {
            let dialog  = btn.closest(".item").nextElementSibling.nextElementSibling; 
            console.log(dialog);
            dialog.showModal();
        });
    })
    close_btn.forEach(btn => {
        btn.addEventListener("click",function(){
            let dialog = btn.closest(".deleteDailog")
            dialog.close();
        })
    })
    delete_btn.forEach(btn => {
        btn.addEventListener("click", function () {
            // Find the closest dialog to the button
            
            let dialog = btn.closest(".item").nextElementSibling; 
            console.log(dialog);
            dialog.showModal(); 

        });
    });
});
    
