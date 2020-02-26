(function () {
    let cart = (localStorage.getItem('cart')) ? JSON.parse(localStorage.getItem('cart')) : [];
    
    const badge_cart = document.getElementById("badge-cart");
    const go_cart = document.getElementById("go_cart");
    const btn_add_cart = document.querySelectorAll("#add_cart");
    const btn_remove_cart = document.querySelectorAll("#removeFromCart");
    
    const notify = (msg, type, config={}) => {
        new Noty({
            type: type,
            theme: 'sunset',
            text: msg,
            timeout: 2800,
            closeWith: 'click',
            layout: 'bottomRight',
            ...config
    
        }).show();
    }

    const add_cart = e => {

        const procuct_id = parseInt(e.target.dataset.id);

        if (cart.find( cart => cart == procuct_id))
        {   
            notify('O item já foi adicionado', 'error');

        } else {
            notify('Adcionado ao Carrinho', 'success');

            cart.push(procuct_id);
        }

        localStorage.setItem('cart', JSON.stringify(cart));

        update_cart_badge();
    }

    const remove_cart = async e => {
        e.preventDefault();

        const procuct_id = parseInt(e.target.dataset.id);

        cart = cart.filter(i => i != procuct_id);

        await localStorage.setItem('cart', JSON.stringify(cart));
        update_cart_badge();

        location.href = BASE_URL + `/cart.php?cart=${btoa(JSON.stringify(cart))}`

    }

    const update_cart_badge = () => {
        return badge_cart.innerText = (cart.length > 9) ? "+9" : String(cart.length);
    }

    const shopping_cart = e => {
        e.preventDefault();
        console.log(BASE_URL)
        location.href = BASE_URL + `/cart.php?cart=${btoa(JSON.stringify(cart))}`;
    }

    btn_add_cart.forEach(elmt => elmt.onclick = add_cart);
    btn_remove_cart.forEach(elmt => elmt.onclick = remove_cart);
    go_cart.onclick = shopping_cart;

    update_cart_badge();
})();