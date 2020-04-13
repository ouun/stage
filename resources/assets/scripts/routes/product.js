export default () => {
  // https://elartica.com/2017/08/03/woocommerce-ajax-add-cart-single-product-page/
  /*global wc_cart_fragments_params*/

  // Ajax add to cart on the product page
  let $warp_fragment_refresh = {
    url: wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' ),
    type: 'POST',
    success: function( data ) {
      if ( data && data.fragments ) {

        $.each( data.fragments, function( key, value ) {
          $( key ).replaceWith( value );
        });

        $( document.body ).trigger( 'wc_fragments_refreshed' );
      }
    },
  };

  // Variable & Grouped Products
  $('.product-type-variable form.cart, .product-type-grouped form.cart').on('submit', function (e) {
    e.preventDefault();

    $('form.cart, .widget_shopping_cart_content').block({
      message: null,
      overlayCSS: {
        cursor: 'none',
      },
    });

    let product_url = window.location,
      form = $(this);

    $.post(product_url, form.serialize() + '&_wp_http_referer=' + product_url, function (result) {
      let cart_dropdown = $('.widget_shopping_cart', result),
        woocommerce_message = $('.woocommerce-notices-wrapper', result);

      // update dropdown cart
      $('.widget_shopping_cart').replaceWith(cart_dropdown);

      // update fragments
      $.ajax($warp_fragment_refresh);

      // Show message
      $('.woocommerce-notices-wrapper').replaceWith(woocommerce_message);

      $('form.cart, .widget_shopping_cart_content').unblock();

    });
  });

  // Simple Products
  $('.product-type-simple .single_add_to_cart_button').on('click', function (e)
  {
    e.preventDefault();

    $('form.cart, .widget_shopping_cart_content').block({
      message: null,
      overlayCSS: {
        cursor: 'none',
      },
    });

    let form = $(this),
      button = $(e.target),
      request = form.serialize() + '&' + encodeURI(button.attr('name')) + '=' + encodeURI(button.attr('value'));

    $.post(form.attr('action'), request + '&_wp_http_referer=' + form.attr('action'), function (result)
    {
      let cart_dropdown = $('.widget_shopping_cart', result),
        woocommerce_message = $('.woocommerce-notices-wrapper', result);

      // update dropdown cart
      $('.widget_shopping_cart').replaceWith(cart_dropdown);

      // Show message
      $('.woocommerce-notices-wrapper').replaceWith(woocommerce_message);

      // update fragments
      $.ajax($warp_fragment_refresh);

      // console.log(woocommerce_message);

      $('form.cart, .widget_shopping_cart_content').unblock();

    })
  });
};
