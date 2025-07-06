# GreenTech WordPress Theme

A modern, professional WordPress theme designed for web development agencies, SEO firms, hosting providers, and software houses. Inspired by contemporary B2B design with clean typography, generous white spacing, and modern green accents.

## Features

### Design & Layout
- **Modern B2B Design**: Clean, professional layout inspired by contemporary design trends
- **Responsive Design**: Fully responsive and mobile-first approach
- **Green Color Scheme**: Modern green (#4CAF50) accent colors with customizable options
- **Inter Typography**: Clean, modern Inter font family from Google Fonts
- **Generous White Space**: Ample spacing for improved readability and visual hierarchy

### Core Functionality
- **WordPress Best Practices**: Built with OOP PHP, namespacing, and modern WordPress standards
- **Performance Optimized**: Fast loading times with optimized assets and lazy loading
- **SEO Ready**: Semantic HTML5, structured data, and SEO-friendly markup
- **Accessibility**: WCAG 2.1 AA compliant with proper accessibility features
- **Translation Ready**: Full internationalization support with .pot file

### Homepage Sections
- **Hero Section**: Customizable title, subtitle, and call-to-action buttons
- **Services Grid**: 4-column responsive services showcase
- **Portfolio**: Filterable project gallery with category filtering
- **Testimonials**: Auto-rotating testimonial carousel
- **Technology Logos**: Partner/technology showcase grid
- **Contact CTA**: Prominent contact information display
- **Blog Feed**: Latest blog posts integration

### Customization Options
- **WordPress Customizer**: Extensive customization options
- **Color Controls**: Primary and secondary color customization
- **Typography Options**: Font family selection
- **Header Settings**: Logo upload, sticky header options
- **Hero Content**: Customizable hero section content
- **Contact Information**: Business details management
- **Social Media**: Social network links
- **Footer Settings**: Copyright and layout options

### Technical Features
- **Custom Post Types**: Portfolio and Services post types
- **Custom Taxonomies**: Portfolio and Service categories
- **Widget Areas**: Multiple widget-ready areas
- **Menu Locations**: Primary, Footer, and Social menus
- **Image Sizes**: Optimized image sizes for different sections
- **Performance**: Optimized assets, lazy loading, and caching support
- **Cross-browser**: Compatible with all modern browsers

## Installation

### Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- Modern web browser

### Quick Installation
1. Download the theme files
2. Upload to your WordPress `/wp-content/themes/` directory
3. Activate the theme from WordPress Admin > Appearance > Themes
4. Customize through Appearance > Customize

### Recommended Plugins
- **Contact Form 7**: For contact forms
- **Yoast SEO**: For enhanced SEO features
- **WooCommerce**: For e-commerce functionality (theme supports WooCommerce)
- **Elementor**: For advanced page building (theme compatible)

## Setup Guide

### 1. Initial Configuration
After activating the theme:

1. **Set Homepage**: Go to Settings > Reading and set a static page as homepage
2. **Configure Menus**: Create menus at Appearance > Menus
3. **Upload Logo**: Upload your logo via Appearance > Customize > Site Identity
4. **Set Colors**: Customize colors in Appearance > Customize > GreenTech Options > Colors

### 2. Content Setup
1. **Create Pages**: Create essential pages (About, Services, Portfolio, Contact)
2. **Add Content**: Use the homepage template for your main page
3. **Portfolio Items**: Add portfolio projects using the Portfolio post type
4. **Blog Posts**: Add blog content for the blog section

### 3. Customizer Options
Navigate to **Appearance > Customize > GreenTech Options**:

#### Colors
- Primary Color (default: #4CAF50)
- Secondary Color (default: #1a1a1a)

#### Typography
- Headings Font
- Body Font

#### Header Settings
- Header Style (Transparent, Solid, Boxed)
- Sticky Header toggle

#### Hero Section
- Hero Title
- Hero Subtitle
- Primary Button Text & URL
- Secondary Button Text & URL

#### Contact Information
- Phone Number
- Email Address
- Business Address
- Website URL

#### Social Media
- Facebook URL
- Twitter URL
- Instagram URL
- LinkedIn URL
- YouTube URL
- GitHub URL

#### Footer Settings
- Copyright Text
- Footer Layout (1-4 columns)

#### Blog Settings
- Blog Layout
- Show Excerpt toggle
- Read More Text

## File Structure

```
greentech-theme/
├── assets/
│   ├── css/
│   ├── js/
│   │   └── main.js
│   └── images/
├── inc/
│   ├── class-admin.php
│   ├── class-assets.php
│   ├── class-customizer.php
│   ├── class-navigation.php
│   ├── class-performance.php
│   ├── class-template-functions.php
│   └── class-theme-setup.php
├── languages/
│   └── greentech.pot
├── template-parts/
├── 404.php
├── archive.php
├── comments.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── page-services.php
├── search.php
├── searchform.php
├── sidebar.php
├── single.php
├── style.css
└── README.md
```

## Customization

### Adding Custom CSS
Add custom styles via:
1. **Customizer**: Appearance > Customize > Additional CSS
2. **Child Theme**: Create a child theme for extensive customizations
3. **Custom CSS File**: Add to `/assets/css/custom.css`

### Child Theme
Create a child theme for custom modifications:

```php
// In child theme's functions.php
<?php
function greentech_child_enqueue_styles() {
    wp_enqueue_style('greentech-parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('greentech-child-style', get_stylesheet_directory_uri() . '/style.css', ['greentech-parent-style']);
}
add_action('wp_enqueue_scripts', 'greentech_child_enqueue_styles');
```

### Custom Templates
- Copy template files to child theme for customization
- Use WordPress template hierarchy
- Leverage template parts for reusable components

### Hooks & Filters
The theme provides various hooks for customization:

```php
// Modify services data
add_filter('greentech_services_data', 'custom_services_data');

// Modify portfolio items
add_filter('greentech_portfolio_data', 'custom_portfolio_data');

// Add custom CSS variables
add_filter('greentech_css_variables', 'custom_css_variables');
```

## Performance

### Optimization Features
- **Lazy Loading**: Automatic image lazy loading
- **Asset Optimization**: Minified CSS and JavaScript
- **Font Loading**: Optimized Google Fonts loading
- **Cache Friendly**: Compatible with caching plugins
- **Image Optimization**: Multiple image sizes for different contexts

### Performance Tips
1. **Use Caching**: Install a caching plugin like WP Super Cache
2. **Optimize Images**: Use WebP format and appropriate sizes
3. **CDN**: Consider using a Content Delivery Network
4. **Minimize Plugins**: Only use necessary plugins

## Browser Support

### Supported Browsers
- Chrome (latest 3 versions)
- Firefox (latest 3 versions)
- Safari (latest 3 versions)
- Edge (latest 3 versions)

### Progressive Enhancement
- Modern browsers get full features
- Older browsers receive core functionality
- Graceful degradation for unsupported features

## Troubleshooting

### Common Issues

#### Menu Not Showing
1. Go to Appearance > Menus
2. Create a menu and assign to "Primary Menu" location

#### Customizer Options Missing
1. Ensure theme is properly activated
2. Check for plugin conflicts
3. Clear cache if using caching plugins

#### Images Not Loading
1. Check image file paths
2. Verify proper image uploads
3. Check file permissions

#### Performance Issues
1. Enable caching
2. Optimize images
3. Minimize active plugins
4. Use a CDN

### Getting Help
1. Check WordPress codex for general WordPress issues
2. Search theme documentation
3. Check browser console for JavaScript errors
4. Test with default WordPress themes to isolate issues

## Changelog

### Version 1.0.0
- Initial release
- Modern B2B design implementation
- Full WordPress Customizer integration
- Performance optimizations
- SEO and accessibility features
- Mobile-responsive design
- Portfolio and Services post types
- Testimonial carousel
- Technology showcase
- Contact information integration

## Credits

### Technologies Used
- **WordPress**: Content Management System
- **Inter Font**: Typography by Google Fonts
- **CSS Grid & Flexbox**: Modern layout techniques
- **Intersection Observer**: Performance-optimized animations
- **PHP 7.4+**: Modern PHP features

### Inspiration
- Design inspired by modern B2B websites
- User experience best practices
- WordPress theme development standards
- Performance optimization techniques

## License

This theme is licensed under the GPL v2 or later.

```
Copyright (C) 2024 GreenTech

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## Support

For support and updates:
- Website: www.greentech.guru
- Email: inquiry@greentech.guru
- Phone: 0544-277588
- Address: Office# 11, 1st Floor Soldier Arcade, Al-Markaz Road, Jhelum

---

**Built with ❤️ by GreenTech Development Team**