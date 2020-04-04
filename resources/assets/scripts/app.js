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
  .ready();
