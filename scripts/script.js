if(document.querySelector(".item")){
        let delete_btn = document.querySelectorAll(".remove");
        let close_btn = document.querySelectorAll(".close");
        let modify_btn = document.querySelectorAll(".changeTo");
        let no_modify_btn = document.querySelectorAll(".no");
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

    document.addEventListener('DOMContentLoaded', function() {
        const changeButtons = document.querySelectorAll('.change');
        const cancelButtons = document.querySelectorAll('.dont_change_it');
        const dialogs = document.querySelectorAll('.change_user_dialog');
    
        // Loop through each change button
        changeButtons.forEach(function(button, index) {
            button.addEventListener('click', function() {
                const dialog = dialogs[index];
                const userId = button.closest('tr').querySelector('td:first-child').textContent;
                const userName = button.closest('tr').querySelector('td:nth-child(2)').textContent.split(' ')[0];
                const userLastName = button.closest('tr').querySelector('td:nth-child(2)').textContent.split(' ')[1];
                const userEmail = button.closest('tr').querySelector('td:nth-child(3)').textContent;
                const userPhone = button.closest('tr').querySelector('td:nth-child(4)').textContent;
    
                // Fill the form fields with the selected user's data
                dialog.querySelector('[name="id"]').value = userId;
                dialog.querySelector('[name="name"]').value = userName;
                dialog.querySelector('[name="last_name"]').value = userLastName;
                dialog.querySelector('[name="email"]').value = userEmail;
                dialog.querySelector('[name="phone_number"]').value = userPhone;
    
                // Open the dialog
                dialog.showModal();
            });
        });
    
        // Close the dialog when the cancel button is clicked
        cancelButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                button.closest('dialog').close();
            });
        });
    });
    
        let delete_btn = document.querySelectorAll(".delete");
        let close_btn = document.querySelectorAll(".cancel-delete");
        let modify_btn = document.querySelectorAll(".modify");
        let no_modify_btn = document.querySelectorAll(".cancel_modify");
        let add_new_dish_btn = document.querySelector(".add");
        let hide_add_dish_dialog = document.querySelector(".hide_add_dish"); 

        add_new_dish_btn.addEventListener("click", function () {
            let dialog = document.querySelector(".add_new_dish"); 
            dialog.showModal();
        }) 
        hide_add_dish_dialog .addEventListener("click", function () {
            let dialog = document.querySelector(".add_new_dish"); 
            dialog.close();
        })
            
        no_modify_btn.forEach(btn => {
            btn.addEventListener("click", function(){
                let dialog = btn.closest(".modifyDailog");
                dialog.close();
            })
        })
        modify_btn.forEach(btn => {
            btn.addEventListener("click", function() {
                let dialog  = btn.closest(".dishe").nextElementSibling.nextElementSibling; 
                
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
                let dialog = btn.closest(".dishe").nextElementSibling; 
                

                dialog.showModal(); 
    
            });
        });
    }
if(document.querySelector(".order")){
    console.log("heelo")
    let show_details_btn = document.querySelectorAll(".show_details");
    let close_details_btn = document.querySelectorAll(".back");
    let delete_btn = document.querySelectorAll(".delete");
    let no_delete_btn = document.querySelectorAll(".cancel_delete");
    let selectes = document.querySelectorAll("select");
    let search_btn = document.querySelector(".search_btn");
    let orders = document.querySelectorAll(".order");
    let change_status_btn = document.querySelectorAll(".change");
    let no_change_status_btn = document.querySelectorAll(".change_close")
    
    
 change_status_btn.forEach(btn => {
    btn.addEventListener("click",function(){
        // let dialog = btn.closest(".state_change_dialog");
        let dialog = btn.parentElement.nextElementSibling
        dialog.showModal()
    })
 })
 no_change_status_btn.forEach(btn => {
    btn.addEventListener("click",function(){
        let dialog = btn.closest("dialog")
        dialog.close()
    })
   

 })
//search bar and filter using select start here
    search_btn.addEventListener("click",() =>{
        selectes[0].selectedIndex = 0;
        selectes[1].selectedIndex = 0;
        let niddel = document.querySelector("#search_bar").value.toLowerCase().trim()
        console.log(niddel)
        let found_match = false
        orders.forEach(div =>{
            let order_match = false
            div.querySelectorAll("p").forEach(p =>{
                if(p.textContent.toLowerCase().trim().includes(niddel)){
                    order_match = true;
                    console.log(`we found a match ${p.textContent.toLowerCase().trim()} and ${niddel}`)
                }
            });
            if(order_match){
                div.style.display = "flex";
                found_match = true;
            }else{
                div.style.display = "none";
            }
        })
        if(!found_match){
            alert("no order was found");
            orders.forEach(order => {order.style.display = "flex"})
        }
    })
    selectes.forEach(select => {
        select.addEventListener("change",() => {
            orders.forEach(order => {
                console.log()
                if((order.querySelector(".year").value === selectes[0].value || selectes[0].value === "all") && (order.querySelector(".status").textContent.toLowerCase().includes(selectes[1].value.toLowerCase()) || selectes[1].value === "all")){
                    order.style.display = "flex";
                }else{
                    order.style.display = "none";
                }
               
            });
        })
    })
//ends here


    delete_btn.forEach(btn => {
        btn.addEventListener("click", function () { 
            let dialog = btn.closest(".order").nextElementSibling.nextElementSibling;
            dialog.showModal();
        })
    })
    no_delete_btn.forEach(btn => {
        btn.addEventListener("click", function(){
            let dialog = btn.closest(".delete_dialog");
            dialog.close();
        })
    });
    show_details_btn.forEach(btn => {
        btn.addEventListener("click", function() {
            let dialog  = btn.closest(".order").nextElementSibling.nextElementSibling.nextElementSibling; 
            console.log(dialog)
            dialog.showModal();
        });
    })
    close_details_btn.forEach(btn => {
        btn.addEventListener("click",function(){
            let dialog = btn.closest(".details_Dailog")
            dialog.close();
        })
    })
}
if(document.querySelector("#myPieChart")){
 

    console.log("we are here");
  // Wait for the DOM to fully load

    fetch("ajax.php")
    .then(function (response) {
        return response.json(); // Parse the response as JSON
    })
    .then(function (data){
        console.log(data);        
            let values =  data.map(element => {
                return element.status_count
            });
            let labels = data.map(element => {
                return element.status
            })
             // console.log(values);
            const ctx = document.getElementById('myPieChart').getContext('2d');
             // Create a new Chart instance
            const myPieChart = new Chart(ctx,
            {
                type: 'pie',       
                data:
                {
                    labels: labels,
                    datasets: [{
                    data: values, // Data values for each slice
                    backgroundColor: ["#190a43","#27038a","#4400ff"], // Colors for each slice
                    borderWidth: 1 // Border width for each slice
                    }]
                },
                options:
                {
                    responsive: true, // Make the chart responsive
                    plugins:
                    {
                        legend: {
                        position: 'top' // Position of the legend
                        },
                        tooltip: {
                             enabled: true // Enable tooltips when hovering over slices
                        }
                    }
                }
            });
        
    })
    fetch("ajax2.php")
    .then(response => {
        return response.json();
    })
    .then(data => {
        console.log(data)
        let dishs = data.map(elemnt =>{
            return elemnt.dish_name;
        })
        let number = data.map(elemnt =>{
            return elemnt.number_of_dish;
        })
        console.log(dishs)
        console.log(number)
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dishs,
                datasets: [{
                    label: 'number of ordered time',
                    data: number,
                    backgroundColor: ["#190a43","#27038a"]
                }]
            },
            options: {
                scales: {
                    y: {
                        barThickness: 20,  
                        categoryPercentage: 0.5
                    }
                }
            }
            
        });
        
    })




   
}
if(document.querySelector(".users_table_body")){

    let change_open_btn = document.querySelectorAll(".change")
    let delete_open_btn = document.querySelectorAll(".delete")
    let change_close_btn = document.querySelectorAll(".dont_change_it")
    let delete_close_btn = document.querySelectorAll(".dont-delete_it")
    console.log()
    change_open_btn.forEach(btn => {
        btn.addEventListener("click",() => {
            let dialog = btn.nextElementSibling
            dialog.showModal();
        })
    })
    change_close_btn.forEach(btn => {
        btn.addEventListener("click",() => {
            let dialog = btn.closest(".change_user_dialog");
            console.log(dialog)
            dialog.close()
        })
    })
    delete_open_btn.forEach(btn => {
        btn.addEventListener("click",() => {
            let dialog = btn.nextElementSibling
            dialog.showModal();
        })
    })
    delete_close_btn.forEach(btn => {
        btn.addEventListener("click",() => {
            let dialog = btn.closest(".delete_user_dialog")
            console.log(dialog)
            dialog.close()
        })
    })


    


}