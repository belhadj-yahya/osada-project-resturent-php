if(document.querySelector(".history")){
    console.log("hello yahya")
    let orders = document.querySelectorAll(".order")
    let notifaction = document.querySelector(".notifation");
    console.log(notifaction.innerHTML)
    document.querySelector(".Show_history").addEventListener("click",function(){
        let niddel = document.querySelector("select").value;
       orders.forEach(order => {
        if(order.querySelector(".date").textContent.toLocaleLowerCase().includes(niddel)){
            order.style.display = "flex"
        }else{
            order.style.display = "none"
        }
       })
    })
    // document.querySelector("select")
}
if(document.querySelector(".main")){
    let search_bar = document.querySelector("input[name='search_bar']");
    search_bar.addEventListener("keydown", (event) => {
        if(event.key == "Enter"){
            event.preventDefault();
        }
    })
    let select = document.querySelector("select");
    let search_bar_btn = document.querySelector(".search_bar_button");
    let dishes = document.querySelectorAll(".dish");


    select.addEventListener("change",function(){
        dishes.forEach(dish => {
            if(dish.querySelector("input[name='dish_category']").value.includes(select.value)){
                console.log("hello we have a match");
                dish.style.display = "flex";
            }else{
                dish.style.display = "none";
            }
        });
    });
    search_bar_btn.addEventListener("click",function(){
        let niddel = document.querySelector("input[name='search_bar']").value.toLowerCase();
        dishes.forEach(dish => {
            if(dish.querySelector(".name").textContent.toLocaleLowerCase().includes(niddel)){
                dish.style.display = "flex";
            }else{
                dish.style.display = "none";
            }
        });
    })
}
if(document.querySelector(".orders")){
    let total = 0;
    let total_prices = document.querySelectorAll(".quen");
    
    console.log(total_prices);
    total_prices.forEach(one => {
        one.addEventListener("keydown", (action) => {
            action.preventDefault();
        });
    
        let input = Number(one.value);
        let price = one.parentElement.nextElementSibling.querySelector(".price").value;
        total += Number(one.value * price);

        one.addEventListener("input", function () {
            console.log("we are in input");
            let price = one.parentElement.nextElementSibling.querySelector(".price").value;
            let new_input = Number(this.value);
    
            if (new_input < input) {
                console.log("we are in if");
                total -= Number(price);
                input = new_input;
            } else if (input < new_input) {
                console.log("we are in else if");
                total += Number(price);
                input = new_input;
            }
    
            document.querySelector(".total_to_use").value = total.toFixed(2);
            document.querySelector(".total").textContent = total.toFixed(2) + "$";
        });
    });
    
    document.querySelector(".total_to_use").value = total.toFixed(2);
    document.querySelector(".total").textContent = total.toFixed(2) + "$";
    
}
if(document.querySelector(".log_in")){
    let check = true;
    let show_pass = document.querySelector("input[name='see']")
    let pass = document.querySelector("input[name='password']");
    show_pass.addEventListener("click",function(){
        if(check == true){
          pass.setAttribute("type" ,"text")
        }else{
            pass.setAttribute("type" ,"password")
        }
        check = !check
    })
}

