export default () => {
  // Hide "Update Cart"-Button
  $("[name='update_cart']").addClass('invisible');

  // Auto update cart on quantity change
  $('div.woocommerce').on('click', 'input.qty', function(){
    $("[name='update_cart']").trigger("click");
  });
};
