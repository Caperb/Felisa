<template>
  <div>
<Home v-if="activePage =='home'" @setPage="setPage"/>
<Shop v-if="activePage =='shop'" :selectedCategorieProp='selectedCategorie' :selectedSubCategorieProp='selectedSubCategorie'
:selectedCategorieNaamProp='selectedCategorieNaam' :selectedSubCategorieNaamProp='selectedSubCategorieNaam' @setPage="setPage"/>
<Cart v-if="activePage =='cart'" :cartProp='cart' @editCart='editCart' @deleteProduct='deleteProduct' @setPage="setPage"/>
<ProductDetailPage v-if="activePage =='productDetailPage'" :selectedItem='selectedItem' @addToCart="addToCart" @setPage="setPage"/>
</div>
</template>

<script>
  import Home from '@/Layouts/homepage/Home'
  import Shop from '@/Layouts/homepage/Shop'
  import Cart from '@/Layouts/homepage/Cart'
  import ProductDetailPage from '@/Layouts/homepage/ProductDetailPage'

  export default {
  components: {
      Home,
      Shop,
      Cart,
      ProductDetailPage
  },

  data() {
      return {
          activePage: 'home',
          orderInfo: {},
          selectedItem: '',
          selectedCategorie: '',
          selectedSubCategorie: '',
          selectedCategorieNaam: '',
          selectedSubCategorieNaam: '',
          cart: [],
      }
  },

  mounted() {},

  methods: {
      setPage(value, item, item2, item3, item4) {
          this.activePage = value;

          if (value == 'productDetailPage') {
              this.selectedItem = item;
          }

          if (value == 'shop' && item != undefined && item3 != undefined) {
              this.selectedCategorie = item;
              this.selectedSubCategorie = item2;
              this.selectedCategorieNaam = item3;
              this.selectedSubCategorieNaam = item4;
          }
      },

      editCart(cart){
        this.cart = cart;
        this.setNewCookie();
      },

      deleteProduct(index){
        this.cart.splice(index, 1);
        this.setNewCookie();
      },

      setNewCookie(){
        var date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = "cart=" + JSON.stringify(this.cart) + "; expires=" + date.toUTCString();
      },

      addToCart(item) {

        var name = 'cart';
        // Get cookie using our custom function
        var firstName = this.getCookieCheck(name);

        if (firstName != null) {
            // Split cookie string and get all individual name=value pairs in an array
            var cookieArr = document.cookie.split(";");
            // Loop through the array elements
            for (var i = 0; i < cookieArr.length; i++) {
                var cookiePair = cookieArr[i].split("=");
                /* Removing whitespace at the beginning of the cookie name
                and compare it with the given string */
                if (name == cookiePair[0].trim()) {
                    // Decode the cookie value and return
                    var newArray = JSON.parse(decodeURIComponent(cookiePair[1]));

                    newArray.push(item);
                    var date = new Date();
                    date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
                    document.cookie = "cart=" + JSON.stringify(newArray) + "; expires=" + date.toUTCString();
                    this.cart = newArray;
                }
            }
        } else {
            this.cart.push(item);
            var date = new Date();
            date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
            document.cookie = "cart=" + JSON.stringify(this.cart) + "; expires=" + date.toUTCString();
        }
    },

    getCookieCheck(name) {
        // Split cookie string and get all individual name=value pairs in an array
        var cookieArr = document.cookie.split(";");

        // Loop through the array elements
        for (var i = 0; i < cookieArr.length; i++) {
            var cookiePair = cookieArr[i].split("=");

            /* Removing whitespace at the beginning of the cookie name
            and compare it with the given string */
            if (name == cookiePair[0].trim()) {
                // Decode the cookie value and return
                return decodeURIComponent(cookiePair[1]);
            }
        }

        // Return null if not found
        return null;
    },
  },
}
</script>
