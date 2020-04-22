export default () => {
  // Auto update cart on quantity change
  $('div.woocommerce').on('change', 'input.qty', function(){
    $("[name='update_cart']").trigger("click");
  });
};
