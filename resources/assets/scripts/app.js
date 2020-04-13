/**
 * External Dependencies
 */
import { router } from 'js-dom-router';
import 'jquery';

/**
 * DOM-based routing
 */
import common from './routes/common';
import archive from './routes/archive';
import product from './routes/product';
import {checkout} from './routes/checkout';
import cart from './routes/cart';

/**
 * Set up DOM router
 *
 * .on(<name of body class>, callback)
 *
 * See: {@link http://goo.gl/EUTi53 | Markup-based Unobtrusive Comprehensive DOM-ready Execution} by Paul Irish
 */
router
  .on('stage', common)
  .on('archive', archive)
  .on('single-product', product)
  .on('checkout', checkout.init)
  .on('cart', cart)
  .ready();
