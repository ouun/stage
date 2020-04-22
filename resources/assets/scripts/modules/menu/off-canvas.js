import {search} from "./search";
import {overlay} from "../overlay";
import {objects} from "../config";

/**
 * Off-Canvas Menu
 *
 * @type {{init: offCanvas.init, triggerEvent: offCanvas.triggerEvent, close: offCanvas.close, open: offCanvas.open}}
 */
export const offCanvas = {

  isAutoHideMenu: false,
  isInitialized:  false,
  isOpen:         false,

  init: function () {
    if ( !offCanvas.isInitialized ) {
      // Add Event Listener
      offCanvas.triggerEvent();
    }
  },

  /**
   * Event Listener: Open on icon click
   */
  triggerEvent: function () {
    objects.navTrigger.on('click', function ( e ) {
      e.preventDefault();

      console.log('trigger');

      if ( offCanvas.isOpen ) {
        offCanvas.close();
      } else {
        offCanvas.open()
      }
    });
  },

  open: function () {
    // Change burger to close icon
    objects.navTrigger.addClass('is-visible is-active');

    // Set-Up submenu
    if ( !offCanvas.isInitialized ) {
      subMenu.init();
    }

    // Open overlay
    overlay.open();

    // Remove auto-hidden menu support
    if ( objects.mainHeader.hasClass('auto-hide') ) {
      this.isAutoHideMenu = true;
      objects.mainHeader.removeClass('auto-hide');
    }

    // Display menu
    objects.offCanvasMenu.removeClass('invisible').removeClass('is-hidden');

    // Add visible class to main header
    objects.mainHeader.addClass('is-visible');

    // Add visible class to main container and hide body overflow
    objects.main.addClass('is-visible');

    // objects.document.addClass('overflow-y-hidden');
    // Fix cut of menu for relative menu
    if (objects.mainHeader.hasClass('relative')) {
      $('html, body').addClass('overflow-hidden fixed h-full');
    }

    // Close search
    search.close();

    // Set new state
    this.isOpen = true;

    // Set state cause we init only once
    this.isInitialized = true;
  },

  close: function () {
    objects.navTrigger.removeClass('is-visible is-active');
    objects.offCanvasMenu.addClass('is-hidden');

    $('.is-visible').removeClass('is-visible');
    objects.document.removeClass('overflow-y-hidden');
    if (objects.mainHeader.hasClass('relative')) {
      $('html, body').removeClass('overflow-hidden fixed h-full');
    }

    // Close overlay
    overlay.close();

    // Set new state
    this.isOpen = false;
  },

};

/**
 * Off-Canvas Submenus
 *
 * @type {{init: subMenu.init, addBackLinks: subMenu.addBackLinks, preventClick: subMenu.preventClick, open: subMenu.open}}
 */
const subMenu = {

  init: function () {
    // Init only once
    if ( !offCanvas.isInitialized ) {
      subMenu.preventClick();
      subMenu.addBackLinks();
      subMenu.open();
    }
  },

  /**
   * Add back menu item & link item
   */
  addBackLinks: function () {
    // Add DOM markup
    objects.offCanvasMenu.find('li.depth-1.has-children').find('ul').each(function () {
      // Clone missing link
      $( this ).parent().children('a:not(.go-back):first').clone().wrap('<li class="selected-copy"></li>').parent().prependTo($(this));

      // Add .go-back links
      let linkText = $( this ).parent('li').parent('ul').children('.selected-copy').children('a:first').text();

      if ( linkText === '' ) {
        linkText = 'back';
      }

      // let $back_text = $(this).parent().children('a:first').text();
      $( this ).prepend('<a href="#" class="go-back"><span>' + linkText + '</span></a>');
    });

    // Add Event Listener to close submenu via back link
    objects.offCanvasMenu.find('.go-back').on('click', function(){
      $(this).parent('ul').removeClass('is-visible').parent('.has-children').parent('ul').removeClass('moves-out');
    });
  },

  /**
   * Event Listener: Open a submenu
   */
  open: function () {
    objects.offCanvasMenu.find('.has-children').children('a').on('click', function(event) {
      event.preventDefault();
      const selected = $(this);
      if ( !selected.next('ul').hasClass('is-visible') ) {
        selected.addClass('selected').next('ul').addClass('is-visible').end().parent('.has-children').parent('ul').addClass('moves-out');
        selected.parent('.has-children').siblings('.has-children').children('ul').removeClass('is-visible').end().children('a').removeClass('selected');
        overlay.open();
      } else {
        selected.removeClass('selected').next('ul').removeClass('is-visible').end().parent('.has-children').parent('ul').removeClass('moves-out');
        overlay.open();
      }
      search.close();
    });
  },

  /**
   * Prevent click & barba.js events if menu has children
   */
  preventClick: function () {
    objects.offCanvasMenu.find('.menu-item.has-children > a').on('click', function(event){
      event.preventDefault();
    }).attr( 'data-loader-prevent', 'self' );
  },
};
