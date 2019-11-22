import {overlay} from "../overlay";
import {search} from "./search";

/**
 * Main Menu
 *
 * @type {{init: dropdown.init, close: dropdown.close, open: dropdown.open, clickOpen: dropdown.clickOpen}}
 */
export const dropdown = {

  isInitialized: false,
  isOpen:        false,

  /**
   * Init Dropdown Menu
   */
  init: function () {
    if ( !dropdown.isInitialized ) {
      // Add Event Listener
      dropdown.clickOpen();

      // Init Mega Menu
      megaMenu.init();

      // Set state cause we init only once
      this.isInitialized = true;
    }
  },

  /**
   * Open menu on click if has class `.click-open'
   */
  clickOpen: function () {
    $('li.has-children.click-open > a').attr("href", "#").on('click', function ( e ) {
      e.preventDefault();

      if ( dropdown.isOpen ) {
        dropdown.close();
      } else {
        dropdown.open( $(this) )
      }
    }).attr( 'data-loader-prevent', 'self' );
  },

  /**
   * Open menu
   */
  open: function ( $item ) {
    // Close all other Dropdown
    dropdown.close();

    // Open new dropdown
    $item.parent().addClass('nav-is-visible');
    $item.addClass('nav-is-visible');

    // Close search
    search.close();

    // Open overlay
    overlay.open();

    // Set new state
    this.isOpen = true;
  },

  /**
   * Close menu
   */
  close: function () {
    if ( dropdown.isOpen ) {
      $('.nav-is-visible').removeClass('nav-is-visible');

      // Close overlay
      overlay.close();
    }

    // Set new state
    this.isOpen = false;
  },

};

/**
 * Main Menu: Dropdown Mega Menu
 */
const megaMenu = {

  $menu: $('nav.nav-primary .has-children.depth-1').find('li.depth-2 > ul.sub-menu').find('.has-children'),

  init: function() {
    megaMenu.preventClick();
    megaMenu.addBackLinks();
    megaMenu.openItem();
  },

  preventClick: function () {
    this.$menu.children('a').on('click', function(event){
      event.preventDefault();
      $(this).addClass('prevent');
    });
  },

  addBackLinks: function () {
    // Display back menu items
    this.$menu.find('.go-back').each(function () {
      $(this).removeClass('hidden').addClass('prevent');
    });

    // Submenu items: Add "go back" links
    this.$menu.find('.go-back').on('click', function(e) {
      e.preventDefault();
      $(this).parent('ul').parent('li.has-children').addClass('hide-children').removeClass('show-children').parent('ul').removeClass('moves-out');
    });
  },

  openItem: function () {
    //open submenu
    this.$menu.children('a').on('click', function(event){
      event.preventDefault();
      let $selected = $(this);
      if ( $selected.parent('li').hasClass('hide-children') ) {
        //desktop version only
        $selected.addClass('selected').parent('li').removeClass('hide-children').addClass('show-children').end().parent('.has-children').parent('ul').addClass('moves-out');
        $selected.parent('.has-children').siblings('.has-children').parent('li').addClass('hide-children').end().children('a').removeClass('selected');
        overlay.open();
      } else {
        $selected.removeClass('selected').parent('li').addClass('hide-children').end().parent('.has-children').parent('ul').removeClass('moves-out');
        overlay.close();
      }
    });
  },
};
