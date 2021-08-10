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

        // Register Social Links Type.
        add_action('graphql_register_types', [$this, 'register_social_links_type']);

        // Register Footer Type and Field.
        add_action('graphql_register_types', [$this, 'register_footer_type']);
        add_action('graphql_register_types', [$this, 'register_footer_field']);

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
     * Register footer type.
     */
    public function register_footer_type()
    {
        register_graphql_object_type(
            'WHHFooter',
            [
                'description' => __('Header Type', 'headless-cms'),
                'fields' => [
                    'copyrightText' => [
                        'type' => 'String',
                        'description' => __('Copyright text', 'headless-cms'),
                    ],
                    'socialLinks' => [
                        'type' => ['list_of' => 'HCMSSocialLinks'],
                        'description' => __('Social links', 'headless-cms'),
                    ],
                    'sidebarOne' => [
                        'type' => 'String',
                        'description' => __('sidebarOne', 'headless-cms'),
                    ],
                    'sidebarTwo' => [
                        'type' => 'String',
                        'description' => __('sidebarTwo', 'headless-cms'),
                    ],
                ],
            ]
        );
    }

    /**
     * Register footer field
     */
    public function register_footer_field()
    {

        register_graphql_field(
            'RootQuery',
            'getFooter',
            [
                'description' => __('Get footer', 'headless-cms'),
                'type' => 'WHHFooter',
                'resolve' => function () {

                    /**
                     * Here you need to return data that matches the shape of the "Dog" type. You could get
                     * the data from the WP Database, an external API, or static values.
                     * For example in this case we are getting it from WordPress database.
                     */
                    return [
                        'copyrightText' => $this->get_copyright_text(),
                        'sidebarOne' => $this->get_sidebar('sidebar-2'),
                        'sidebarTwo' => $this->get_sidebar('hcms-footer-sidebar-2'),
                    ];

                },
            ]
        );

    }

    /**
     * Register social links field
     */
    public function register_social_links_type()
    {
        register_graphql_object_type(
            'HCMSSocialLinks',
            [
                'description' => __('Social Links Type', 'headless-cms'),
                'fields' => [
                    'iconName' => [
                        'type' => 'String',
                        'description' => __('Icon name', 'headless-cms'),
                    ],
                    'iconUrl' => [
                        'type' => 'String',
                        'description' => __('Icon url', 'headless-cms'),
                    ],
                ],
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

    /**
     * Get social icons
     *
     * @return array $social_icons
     */
    public function get_social_icons()
    {

        $social_icons = [];
        $social_icons_name = ['facebook', 'twitter', 'instagram', 'youtube'];

        foreach ($social_icons_name as $social_icon_name) {

            $social_link = get_theme_mod(sprintf('rae_%s_link', $social_icon_name));

            if ($social_link) {
                array_push(
                    $social_icons,
                    [
                        'iconName' => esc_attr($social_icon_name),
                        'iconUrl' => esc_url($social_link),
                    ]
                );
            }
        }

        return $social_icons;

    }

    /**
     * Get copyright text
     *
     * @return mixed
     */
    public function get_copyright_text()
    {

        $copy_right_text = get_theme_mod('rae_footer_text');

        return $copy_right_text ? $copy_right_text : '';
    }

    /**
     * Returns the content of all the sidebars with given sidebar id.
     *
     * @param string $sidebar_id Sidebar id.
     *
     * @return false|string
     */
    public function get_sidebar($sidebar_id)
    {
        ob_start();

        dynamic_sidebar($sidebar_id);
        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

}

new Header_Footer_Schema();