<?php

class Header_Footer_Schema
{

    /**
     * Construct method.
     */
    public function __construct()
    {
        $this->setup_hooks();
    }

    /**
     * To setup action/filter.
     *
     * @return void
     */
    public function setup_hooks()
    {

        /**
         * Action
         */

        // Register Header Type and Field.
        add_action('graphql_register_types', [$this, 'register_header_type']);
        add_action('graphql_register_types', [$this, 'register_header_field']);

    }

    /**
     * Register header type.
     */
    public function register_header_type()
    {
        register_graphql_object_type(
            'WHHHeader',
            [
                'description' => __('Header Type', 'headless-cms'),
                'fields' => [
                    'siteLogoUrl' => [
                        'type' => 'String',
                        'description' => __('Site logo URL', 'headless-cms'),
                    ],
                    'siteTitle' => [
                        'type' => 'String',
                        'description' => __('Site title', 'headless-cms'),
                    ],
                    'siteTagLine' => [
                        'type' => 'String',
                        'description' => __('Site tagline', 'headless-cms'),
                    ],
                    'favicon' => [
                        'type' => 'String',
                        'description' => __('favicon', 'headless-cms'),
                    ],
                ],
            ]
        );
    }

    /**
     * Register header field
     */
    public function register_header_field()
    {

        register_graphql_field(
            'RootQuery',
            'getHeader',
            [
                'description' => __('Get header', 'headless-cms'),
                'type' => 'WHHHeader',
                'resolve' => function () {

                    /**
                     * Here you need to return data that matches the shape of the "Dog" type. You could get
                     * the data from the WP Database, an external API, or static values.
                     * For example in this case we are getting it from WordPress database.
                     */
                    return [
                        'siteLogoUrl' => $this->get_logo_url('custom_logo'),
                        'siteTitle' => get_bloginfo('title'),
                        'siteTagLine' => get_bloginfo('description'),
                        'favicon' => get_site_icon_url(),
                    ];

                },
            ]
        );

    }

    /**
     * Get logo URL.
     *
     * @param string $key Key.
     *
     * @return string Image.
     */
    public function get_logo_url($key)
    {

        $custom_logo_id = get_theme_mod($key);
        $image = wp_get_attachment_image_src($custom_logo_id, 'full');

        return $image[0];
    }

}

new Header_Footer_Schema();