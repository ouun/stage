{{--
Content Product Category
@version  2.6.1
--}}

<div @php( wc_product_cat_class( '', $category ) )>
  @action('woocommerce_before_subcategory', $category  )
  @action('woocommerce_before_subcategory_title', $category  )
  @action('woocommerce_shop_loop_subcategory_title', $category  )
  @action('woocommerce_after_subcategory_title', $category  )
  @action('woocommerce_after_subcategory', $category  )
</div>
