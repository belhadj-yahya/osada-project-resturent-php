
    let delete_btn = document.querySelectorAll(".remove");
    let close_btn = document.querySelectorAll(".close");
    let modify_btn = document.querySelectorAll(".changeTo");
    let no_modify_btn = document.querySelectorAll(".no");
    if(document.querySelector(".item")){

        no_modify_btn.forEach(btn => {
            btn.addEventListener("click", function(){
                let dialog = btn.closest(".updated");
                dialog.close();
            })
        })
        modify_btn.forEach(btn => {
            btn.addEventListener("click", function() {
                let dialog  = btn.closest(".item").nextElementSibling.nextElementSibling; 
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
                let dialog = btn.closest(".item").nextElementSibling; 
                dialog.showModal(); 
    
            });
        });
    }
    if(document.querySelector(".dishes")){
        no_modify_btn.forEach(btn => {
            btn.addEventListener("click", function(){
                let dialog = btn.closest(".updated");
                console.log(dialog);
                dialog.close();
            })
        })
        modify_btn.forEach(btn => {
            btn.addEventListener("click", function() {
                let dialog  = btn.closest(".dishes").nextElementSibling.nextElementSibling; 
                console.log(dialog);
                dialog.showModal();
            });
        })
        close_btn.forEach(btn => {
            btn.addEventListener("click",function(){
                let dialog = btn.closest(".deleteDailog")
                console.log(dialog);
                dialog.close();
            })
        })
        delete_btn.forEach(btn => {
            btn.addEventListener("click", function () { 
                let dialog = btn.closest(".dishes").nextElementSibling; 
                console.log(dialog);
                dialog.showModal(); 
    
            });
        });
    }

    
