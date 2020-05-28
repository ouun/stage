/*

Tailwind - The Utility-First CSS Framework

Welcome to the Tailwind config file. This is where you can customize
Tailwind specifically for your project. Don't be intimidated by the
length of this file. It's really just a big JavaScript object and
we've done our very best to explain each section.

View the full documentation at https://tailwindcss.com.

*/

const wordpress = require('tailwindcss-wordpress');
const aspectRatio = require('tailwindcss-aspect-ratio');
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  purge: {
    content: [
      './index.php',
      './app/**/*.php',
      './config/defaults.php',
      './resources/views/**/*.php',
      './resources/assets/scripts/**/*.js',
    ],
    options: {
      whitelist: [
      ],
      whitelistPatterns: [
        /^z(-.*)?$/,
        /^bg(-.*)?$/,
        /^text(-.*)?$/,
        /^placeholder(-.*)?$/,
        /^border(-.*)?$/,
        /^opacity(-.*)?$/,
        /^flex(-.*)?$/,
        /^h(-.*)?$/,
        /^w(-.*)?$/,
        /^min(-.*)?$/,
        /^max(-.*)?$/,
        /^p[a-z]{0,1}(-.*)?$/,
        /^m[a-z]{0,1}(-.*)?$/,
      ],
    },
  },
  theme: {

    /*
    |-----------------------------------------------------------------------------
    | Screens                      https://tailwindcss.com/docs/responsive-design
    |-----------------------------------------------------------------------------
    |
    | Class name: .{screen}:{utility}
    |
    */

    screens: {
      'sm': '576px',
      'md': '768px',
      'lg': '992px',
      'xl': '1200px',
      'xxl': '1600px',
    },


    /*
    |-----------------------------------------------------------------------------
    | Default Colors               https://tailwindcss.com/docs/customizing-colors
    |-----------------------------------------------------------------------------
    |
    | By default these colors are automatically shared by the textColor, borderColor,
    | and backgroundColor utilities, so the above configuration would generate
    | classes like .text-green-100, .border-blue-300, and .bg-red-500.
    |
    */

    colors: {
      'inherit': 'inherit',
      'transparent': 'transparent',

      'body':       'var(--color-body)',

      'link':       'var(--color-link)',
      'hover':       'var(--color-primary)',

      'copy':       'var(--color-copy)',
      'heading':    'var(--color-heading)',

      'primary':    'var(--color-primary)',
      'secondary':  'var(--color-secondary)',

      'black':      'var(--color-black)',
      'white':      'var(--color-white)',

      'gray': {
        100: 'var(--color-gray-100)',
        200: 'var(--color-gray-200)',
        300: 'var(--color-gray-300)',
        400: 'var(--color-gray-400)',
        500: 'var(--color-gray-500)',
        600: 'var(--color-gray-600)',
        700: 'var(--color-gray-700)',
        800: 'var(--color-gray-800)',
        900: 'var(--color-gray-900)',
      },

      red: {
        light: 'var(--color-red-light)',
        default: 'var(--color-red)',
        dark: 'var(--color-red-dark)',
      },

      green: {
        light: 'var(--color-green-light)',
        default: 'var(--color-green)',
        dark: 'var(--color-green-dark)',
      },

      blue: {
        light: 'var(--color-blue-light)',
        default: 'var(--color-blue)',
        dark: 'var(--color-blue-dark)',
      },
    },


    /*
    |-----------------------------------------------------------------------------
    | Default Spacing             https://tailwindcss.com/docs/customizing-spacing
    |-----------------------------------------------------------------------------
    |
    | By default the spacing scale is shared by the padding, margin, gap, etc.
    | utilities so the above configuration would generate classes like
    | .p-2, .mt-3, .w-5, .h-6, .gap- etc.
    |
    */

    spacing: {
      'px': '1px',
      '0': '0',
      '1': '0.25rem',
      '2': '0.5rem',
      '3': '0.75rem',
      '4': '1rem',
      '5': '1.25rem',
      '6': '1.5rem',
      '8': '2rem',
      '10': '2.5rem',
      '12': '3rem',
      '16': '4rem',
      '20': '5rem',
      '24': '6rem',
      '32': '8rem',
      '40': '10rem',
      '48': '12rem',
      '56': '14rem',
      '64': '16rem',
      'half': '50%',
      'full': '100%',
      'half-block-spacing': 'calc( var( --block-spacing ) / 2 )',
      'block-spacing': 'var( --block-spacing )',
      'gutter': 'var( --gutter )',
    },


    /*
    |-----------------------------------------------------------------------------
    | Default Sizes                                                 Stage Specific
    |-----------------------------------------------------------------------------
    |
    | By default the sizes scale is shared by the height, width, max-height, etc.
    | utilities and extends the spacing. so the above configuration would generate
    | classes like .w-2, .h-3, .max-w-1/3, .max-h-6, etc.
    |
    */

    sizes: theme => ({
      'xs': '20rem',
      'sm': '30rem',
      'md': '40rem',
      'lg': '50rem',
      'xl': '60rem',
      '2xl': '70rem',
      '3xl': '80rem',
      '4xl': '90rem',
      '5xl': '100rem',
      '1/2': '50%',
      '1/3': '33.33333%',
      '2/3': '66.66667%',
      '1/4': '25%',
      '3/4': '75%',
      '1/5': '20%',
      '2/5': '40%',
      '3/5': '60%',
      '4/5': '80%',
      '1/6': '16.66667%',
      '2/6': '33.33334%',
      '3/6': '50%',
      '4/6': '66.66668%',
      '5/6': '83.33333%',
      '1/12': '8.33333%',
      '2/12': '16.66667%',
      '3/12': '25%',
      '4/12': '33.33333%',
      '5/12': '41.66667%',
      '6/12': '50%',
      '7/12': '58.33333%',
      '8/12': '66.66667%',
      '9/12': '75%',
      '10/12': '83.33333%',
      '11/12': '91.66667%',
      'full': '100%',
      'half': '50%',
      'auto': 'auto',
      'none': 'none',
      ...theme('spacing'),
    }),

    /*
    |-----------------------------------------------------------------------------
    | Text colors                         https://tailwindcss.com/docs/text-color
    |-----------------------------------------------------------------------------
    |
    | Class name: .text-{color}
    |
    */

    textColor: theme => theme('colors'),


    /*
    |-----------------------------------------------------------------------------
    | Background colors             https://tailwindcss.com/docs/background-color
    |-----------------------------------------------------------------------------
    |
    | Class name: .bg-{color}
    |
    */

    backgroundColor: theme => theme('colors'),

    /*
    |-----------------------------------------------------------------------------
    | Fonts                                    https://tailwindcss.com/docs/fonts
    |-----------------------------------------------------------------------------
    |
    | Class name: .font-{name}
    | CSS property: font-family
    |
    */

    fontFamily: {
      'heading': 'var(--heading-font-family)',
      'copy': 'var(--copy-font-family)',
      'sans': [
        'Inter',
        'system-ui',
        'BlinkMacSystemFont',
        '-apple-system',
        'Segoe UI',
        'Roboto',
        'Oxygen',
        'Ubuntu',
        'Cantarell',
        'Fira Sans',
        'Droid Sans',
        'Helvetica Neue',
        'sans-serif',
      ],
      'serif': [
        'Constantia',
        'Lucida Bright',
        'Lucidabright',
        'Lucida Serif',
        'Lucida',
        'DejaVu Serif',
        'Bitstream Vera Serif',
        'Liberation Serif',
        'Georgia',
        'serif',
      ],
      'mono': [
        'Menlo',
        'Monaco',
        'Consolas',
        'Liberation Mono',
        'Courier New',
        'monospace',
      ],
    },


    /*
    |-----------------------------------------------------------------------------
    | Font sizes                         https://tailwindcss.com/docs/text-sizing
    |-----------------------------------------------------------------------------
    |
    | Class name: .text-{size}
    | CSS property: font-size
    |
    */

    fontSize: {
      'xs':   'var(--font-size-xs)',        // 12px
      'sm':   'var(--font-size-sm)',        // 14px
      'base': 'var(--font-size-base)',      // 16px
      'lg':   'var(--font-size-lg)',        // 18px
      'xl':   'var(--font-size-xl)',        // 20px
      '2xl':  'var(--font-size-2xl)',       // 24px
      '3xl':  'var(--font-size-3xl)',       // 30px
      '4xl':  'var(--font-size-4xl)',       // 36px
      '5xl':  'var(--font-size-5xl)',       // 48px
    },


    /*
    |-----------------------------------------------------------------------------
    | Letter Spacing                   https://tailwindcss.com/letter-spacing.html
    |-----------------------------------------------------------------------------
    |
    | Class name: .tracking-{size}
    | CSS property: letter-spacing
    |
    */

    letterSpacing: {
      tighter: '-0.05em',
      tight: '-0.025em',
      normal: '0',
      wide: '0.025em',
      wider: '0.1em',
      widest: '0.2em',
    },


    /*
    |-----------------------------------------------------------------------------
    | Line Height                         https://tailwindcss.com/line-height.html
    |-----------------------------------------------------------------------------
    |
    | Class name: .leading-{size}
    | CSS property: line-height
    |
    */

    lineHeight: {
      none: '1',
      tight: '1.25',
      snug: '1.375',
      normal: '1.5',
      relaxed: '1.625',
      loose: '2',
    },

    /*
    |-----------------------------------------------------------------------------
    | Width                                    https://tailwindcss.com/docs/width
    |-----------------------------------------------------------------------------
    |
    | Class name: .w-{size}
    |
    */

    width: theme => ({
      'screen': '100vw',
      'half-screen': '50vw',
      ...theme('sizes'),
    }),


    /*
    |-----------------------------------------------------------------------------
    | Height                                  https://tailwindcss.com/docs/height
    |-----------------------------------------------------------------------------
    |
    | Class name: .h-{size}
    |
    */

    height: theme => ({
      'screen': '100vh',
      'half-screen': '50vh',
      ...theme('sizes'),
    }),


    /*
    |-----------------------------------------------------------------------------
    | Minimum width                        https://tailwindcss.com/docs/min-width
    |-----------------------------------------------------------------------------
    |
    | Class name: .min-w-{size}
    |
    */

    minWidth: theme => ({
      'screen': '100vw',
      'half-screen': '50vw',
      ...theme('sizes'),
    }),


    /*
    |-----------------------------------------------------------------------------
    | Minimum height                      https://tailwindcss.com/docs/min-height
    |-----------------------------------------------------------------------------
    |
    | Class name: .min-h-{size}
    |
    */

    minHeight: theme => ({
      'screen': '100vh',
      'half-screen': '50vh',
      ...theme('sizes'),
    }),


    /*
    |-----------------------------------------------------------------------------
    | Maximum width                        https://tailwindcss.com/docs/max-width
    |-----------------------------------------------------------------------------
    |
    | Class name: .max-w-{size}
    |
    */

    maxWidth: theme => ({
      'screen': '100vw',
      'half-screen': '50vw',
      ...theme('sizes'),
    }),


    /*
    |-----------------------------------------------------------------------------
    | Maximum height                      https://tailwindcss.com/docs/max-height
    |-----------------------------------------------------------------------------
    |
    | Class name: .max-h-{size}
    |
    */

    maxHeight: theme => ({
      'screen': '100vh',
      'half-screen': '50vh',
      ...theme('sizes'),
    }),


    /*
    |-----------------------------------------------------------------------------
    | Padding                                https://tailwindcss.com/docs/padding
    |-----------------------------------------------------------------------------
    |
    | Class name: .p{side?}-{size}
    |
    */

    padding: theme => ({
      'initial': 'initial',
      ...theme('spacing'),
    }),


    /*
    |-----------------------------------------------------------------------------
    | Margin                                  https://tailwindcss.com/docs/margin
    |-----------------------------------------------------------------------------
    |
    | Extended spacing
    | Class name: .m{side?}-{size}
    |
    */

    margin: (theme, { negative }) => ({
      'auto': 'auto',
      ...theme('spacing'),
      ...negative(theme('spacing')),
    }),


    /*
    |-----------------------------------------------------------------------------
    | Inset                   https://tailwindcss.com/docs/top-right-bottom-left/
    |-----------------------------------------------------------------------------
    |
    | Class name: .{top|right|bottom|left|inset}-{size]
    |
    */

    inset: theme => ({
      ...theme('sizes'),
    }),


    /*
    |-----------------------------------------------------------------------------
    | Border Width                      https://tailwindcss.com/border-width.html
    |-----------------------------------------------------------------------------
    |
    | Class name: .border-{size?}
    |
    */

    borderWidth: {
      default: '1px',
      '0': '0',
      '2': '2px',
      '3': '3px',
      '4': '4px',
      '6': '6px',
      '8': '8px',
    },


    /*
    |-----------------------------------------------------------------------------
    | Border Radius                    https://tailwindcss.com/docs/border-radius/
    |-----------------------------------------------------------------------------
    |
    | Class name: .{top|right|bottom|left|inset}-{size]
    |
    */

    borderRadius: {
      'inherit': 'inherit',
      ...defaultTheme.borderRadius,
    },


    /*
    |-----------------------------------------------------------------------------
    | Shadows                                https://tailwindcss.com/docs/shadows
    |-----------------------------------------------------------------------------
    |
    | Class name: .shadow-{size?}
    |
    */

    boxShadow: {
      'sm': '0 1px 2px 0 rgba(0, 0, 0, 0.04)',
      'default': '0 2px 4px 0 rgba(0,0,0,0.10)',
      'md': '0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08)',
      'lg': '0 15px 30px 0 rgba(0,0,0,0.11), 0 5px 15px 0 rgba(0,0,0,0.08)',
      'inner': 'inset 0 2px 4px 0 rgba(0,0,0,0.06)',
      'outline': '0 0 0 3px rgba(52,144,220,0.5)',
      'none': 'none',
    },


    /*
    |-----------------------------------------------------------------------------
    | Z-index                                https://tailwindcss.com/docs/z-index
    |-----------------------------------------------------------------------------
    |
    | Class name: .z-{index}
    |
    */

    zIndex: {
      'auto': 'auto',
      '-1': -1,
      '0': 0,
      '1': 1,
      '2': 2,
      '3': 3,
      '4': 4,
      '5': 5,
      '10': 10,
      '20': 20,
      '30': 30,
      '40': 40,
      '50': 50,
    },


    /*
    |-----------------------------------------------------------------------------
    | Opacity                                https://tailwindcss.com/docs/opacity
    |-----------------------------------------------------------------------------
    |
    | Class name: .opacity-{name}
    |
    */

    opacity: {
      '0': '0',
      '10': '10',
      '25': '.25',
      '50': '.5',
      '75': '.75',
      '90': '.9',
      '100': '1',
    },


    /*
    |-----------------------------------------------------------------------------
    | CSS Grid Row            https://github.com/tailwindcss/tailwindcss/pull/1274
    |-----------------------------------------------------------------------------
    |
    | Class name: .grid-row-{name}
    |
    */

    gridRow: {
      'min-content': 'min-content',
    },


    /*
    |-----------------------------------------------------------------------------
    | SVG fill                                   https://tailwindcss.com/docs/svg
    |-----------------------------------------------------------------------------
    |
    | Class name: .fill-{name}
    |
    */

    fill: {
      'current': 'currentColor',
      'none': 'none',
    },


    /*
    |-----------------------------------------------------------------------------
    | SVG stroke                                 https://tailwindcss.com/docs/svg
    |-----------------------------------------------------------------------------
    |
    | Class name: .stroke-{name}
    |
    */

    stroke: {
      'current': 'currentColor',
    },


    /*
    |-----------------------------------------------------------------------------
    | Aspect Ratio Plugin       https://github.com/webdna/tailwindcss-aspect-ratio
    |-----------------------------------------------------------------------------
    |
    | Class name: .aspect-ratio-{name}
    |
    */

    aspectRatio: {
      'square': [1, 1],
      '16/9': [16, 9],
      '2/3': [2, 3],
      '3/2': [3, 2],
      '3/4': [3, 4],
      '4/3': [4, 3],
      '21/9': [21, 9],
    },


    /*
    |-----------------------------------------------------------------------------
    | Flex Grow                            https://tailwindcss.com/docs/flex-grow/
    |-----------------------------------------------------------------------------
    |
    | Class name: .flex-grow-{size}
    |
    */


    flexGrow: {
      '0': 0,
      '1': 1,
      '2': 2,
      '3': 3,
      '4': 4,
      '5': 5,
      default: 1,
    },
  },


  /*
  |-----------------------------------------------------------------------------
  | Variants                 https://tailwindcss.com/docs/configuration#variants
  |-----------------------------------------------------------------------------
  |
  | Here is where you control which variants are generated and what variants are
  | generated for each of those variants.
  |
  | Currently supported variants:
  |   - responsive
  |   - hover
  |   - focus
  |   - active
  |   - group-hover
  |
  | To disable a module completely, use `false` instead of an array.
  |
  */

  variants: {
    aspectRatio: ['responsive'],
    appearance: ['responsive'],
    backgroundAttachment: ['responsive'],
    backgroundColor: ['responsive', 'hover', 'focus', 'focus-within'],
    backgroundPosition: ['responsive'],
    backgroundRepeat: ['responsive'],
    backgroundSize: ['responsive'],
    borderCollapse: [],
    borderColor: ['responsive', 'hover', 'focus', 'focus-within'],
    borderRadius: ['responsive'],
    borderStyle: ['responsive'],
    borderWidth: ['responsive'],
    cursor: ['responsive'],
    display: ['responsive'],
    flexDirection: ['responsive'],
    flexWrap: ['responsive'],
    alignItems: ['responsive'],
    alignSelf: ['responsive'],
    justifyContent: ['responsive'],
    alignContent: ['responsive'],
    flex: ['responsive'],
    flexGrow: ['responsive'],
    flexShrink: ['responsive'],
    float: ['responsive'],
    fontFamily: ['responsive'],
    fontWeight: ['responsive', 'hover', 'focus'],
    height: ['responsive'],
    lineHeight: ['responsive'],
    listStylePosition: ['responsive'],
    listStyleType: ['responsive'],
    margin: ['responsive'],
    maxHeight: ['responsive'],
    maxWidth: ['responsive'],
    minHeight: ['responsive'],
    minWidth: ['responsive'],
    negativeMargin: ['responsive'],
    objectFit: ['responsive'],
    objectPosition: ['responsive'],
    opacity: ['responsive'],
    outline: ['focus'],
    overflow: ['responsive'],
    padding: ['responsive'],
    pointerEvents: ['responsive'],
    position: ['responsive'],
    inset: ['responsive'],
    resize: ['responsive'],
    boxShadow: ['responsive', 'hover', 'focus'],
    fill: [],
    stroke: [],
    tableLayout: ['responsive'],
    textAlign: ['responsive'],
    textColor: ['responsive', 'hover', 'focus'],
    fontSize: ['responsive'],
    fontStyle: ['responsive'],
    textTransform: ['responsive'],
    textDecoration: ['responsive', 'hover', 'focus'],
    fontSmoothing: ['responsive'],
    letterSpacing: ['responsive'],
    userSelect: ['responsive'],
    verticalAlign: ['responsive'],
    visibility: ['responsive'],
    whitespace: ['responsive'],
    wordBreak: ['responsive'],
    width: ['responsive'],
    zIndex: ['responsive'],
  },

  corePlugins: {
    container: false,
  },


  /*
  |-----------------------------------------------------------------------------
  | Plugins                                https://tailwindcss.com/docs/plugins
  |-----------------------------------------------------------------------------
  |
  | Here is where you can register any plugins you'd like to use in your
  | project. Tailwind's built-in `container` plugin is enabled by default to
  | give you a Bootstrap-style responsive container component out of the box.
  |
  | Be sure to view the complete plugin documentation to learn more about how
  | the plugin system works.
  |
  */

  plugins: [
    wordpress,
    aspectRatio,
  ],
};
