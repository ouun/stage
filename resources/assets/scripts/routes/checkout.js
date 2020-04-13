export const checkout = {

  init: function () {
    // Set initial/current step onload without link
    $('.step.step-' + checkout.getCurrentStep()).addClass('current');

    // JS is available, arrange elements
    $( '#checkout-payment' ).hide();
    $( '#checkout-step-indicator' ).show();

    /**
     * Handle WC checkout errors:
     * We through an error if the validation succeeds
     * Catch it and continue to next step
     */
    $( document.body ).on('checkout_error', function() {
      const digthisError = $(document).find('#digthis-prevent-error');
      if( digthisError.length !== 0 ){
        $('.woocommerce-NoticeGroup-checkout, .woocommerce-error, .woocommerce-message').remove();
        $('.steps').hide();

        /* Change it so validation stops */
        $('#current_step').val(checkout.getNextStep());
        $('#checkout-payment').show();

        /* Make the multi-step indicator item clickable */
        checkout.nextStep();
      }
    });

    // Switch to another step if already available
    $( 'li.step > a' ).live( 'click', function() {
      const target = $(this).data('target');
      // console.log(target);

      $('.step.current').removeClass('current');
      $(this).parent().addClass('current');

      $('.steps').hide();
      $('#current_step').val(target);
      $('#checkout-' + target).show();
    });
  },

  /* Prepare next step in indicator element*/
  nextStep: function () {
    let $current = $('.step.step-' + this.getCurrentStep());
    let $next = $current.next();

    /* Make current a link if not already */
    this.makeSpanToLink($current.find('span'));

    /* Make the switch to the next step */
    $current.removeClass('current').addClass('done');
    $next.addClass('current');

    this.makeSpanToLink($next.find('span'));
  },

  /* Transform <span> element to <a> */
  makeSpanToLink: function ( $span ) {
    let next = $span.data('step');

    $span.replaceWith(function () {
      return $("<a href='#step-" + next + "' data-target='" + next + "'>" + $(this).html() + "</a>");
    });
  },

  /* Get the current active step */
  getCurrentStep: function () {
    let $current =  $('ol.multi-steps > .current');

    if ( $current.length !== 0 ) {
      return $current.data('step');
    } else {
      return $('#current_step').val();
    }
  },

  /* Get the next step to come */
  getNextStep: function () {
    return $('ol.multi-steps > .step-' + this.getCurrentStep() ).next().data('step');
  },
};
