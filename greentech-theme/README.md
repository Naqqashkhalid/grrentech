# GreenTech WordPress Theme

A modern, professional WordPress theme built specifically for Gutenberg. Perfect for web development agencies, SEO firms, hosting providers, and software houses. Features a clean block-based design with extensive customization options and modern development practices.

## 🚀 Features

### Modern Block-Based Design
- **Gutenberg-First**: Built specifically for the WordPress block editor
- **Custom Block Styles**: 20+ custom block styles for enhanced design flexibility
- **Block Patterns**: 8 pre-built patterns for quick page creation
- **No Hardcoded Content**: All layouts created through Gutenberg blocks

### Professional Design
- **Clean & Modern**: Professional B2B design with generous white space
- **Green Color Scheme**: Modern green (#4CAF50) accent colors with full customization
- **Inter Typography**: Clean, modern Inter font family from Google Fonts
- **Responsive Design**: Mobile-first approach with perfect display on all devices

### Extensive Customization
- **WordPress Customizer Integration**: Complete customization through native WordPress interface
- **Color Options**: Primary, secondary, and accent color customization
- **Typography Controls**: Font selection and scaling options
- **Layout Options**: Container width, boxed layout, and header styles
- **Contact Information**: Built-in contact details management
- **Social Media**: Social links integration

### Performance & SEO
- **Optimized Performance**: Fast loading with optimized assets and lazy loading
- **SEO-Friendly**: Clean HTML5 markup with structured data
- **Accessibility Ready**: WCAG 2.1 AA compliance with proper ARIA labels
- **Modern JavaScript**: ES6+ with performance optimizations

### Developer-Friendly
- **Object-Oriented PHP**: Clean OOP architecture with namespacing
- **WordPress Coding Standards**: Follows all WordPress best practices
- **Translation Ready**: Complete .pot file with 200+ translatable strings
- **Extensible**: Hook-based architecture for easy customization

## 📋 Requirements

- **WordPress**: 6.0 or higher
- **PHP**: 8.0 or higher
- **MySQL**: 5.6 or higher
- **Modern Browser**: Support for ES6+ JavaScript

## 🔧 Installation

### Method 1: Upload via WordPress Admin
1. Download the theme ZIP file
2. Go to **Appearance → Themes → Add New → Upload Theme**
3. Choose the ZIP file and click **Install Now**
4. Click **Activate** to enable the theme

### Method 2: FTP Upload
1. Download and extract the theme files
2. Upload the `greentech-theme` folder to `/wp-content/themes/`
3. Go to **Appearance → Themes** and activate GreenTech

### Method 3: WordPress CLI
```bash
wp theme install greentech-theme.zip --activate
```

## ⚙️ Quick Setup

### 1. Basic Configuration
1. **Set Homepage**: Go to **Settings → Reading** and set a static page
2. **Upload Logo**: Go to **Appearance → Customize → Site Identity**
3. **Set Colors**: Go to **Appearance → Customize → Branding & Design → Colors**

### 2. Create Menus
1. Go to **Appearance → Menus**
2. Create menus for:
   - **Primary Menu** (main navigation)
   - **Footer Menu** (footer links)
   - **Social Menu** (social media links)

### 3. Add Contact Information
1. Go to **Appearance → Customize → Contact Information**
2. Add your business details:
   - Phone number
   - Email address
   - Business address
   - Website URL

### 4. Configure Social Media
1. Go to **Appearance → Customize → Contact Information → Social Media**
2. Add your social media URLs

## 🎨 Customization

### Colors
- **Primary Color**: Main brand color (default: #4CAF50)
- **Secondary Color**: Text and accent color (default: #1a1a1a)
- **Accent Color**: Highlight color (default: #66bb6a)

### Typography
- **Heading Font**: Choose from Inter, Poppins, Roboto, Open Sans, Lato
- **Body Font**: Same font options as headings
- **Font Scale**: Adjust overall font sizing (0.8x to 1.2x)

### Layout Options
- **Container Width**: Adjust content width (1000px to 1400px)
- **Boxed Layout**: Enable/disable boxed layout
- **Header Style**: Transparent, solid, or boxed header
- **Sticky Header**: Enable/disable sticky navigation

### Blog Settings
- **Layout**: Grid, list, or masonry layout
- **Columns**: 1-4 columns for grid layout
- **Excerpts**: Show/hide post excerpts
- **Excerpt Length**: Customize excerpt word count
- **Read More Text**: Customize read more button text

## 🧩 Block Patterns

GreenTech includes 8 professionally designed block patterns:

1. **Hero Section**: Full-width hero with title, subtitle, and CTA buttons
2. **Services Grid**: 4-column service showcase with icons
3. **Testimonials**: Customer testimonials with quotes and author info
4. **Call to Action**: Prominent CTA section with gradient background
5. **About Section**: Image and content side-by-side layout
6. **Portfolio Grid**: Responsive project showcase grid
7. **Team Section**: Team member profiles with photos
8. **FAQ Section**: Frequently asked questions layout

### Using Block Patterns
1. Create a new page or edit existing content
2. Click the **+** button to add a block
3. Go to the **Patterns** tab
4. Browse **GreenTech** categories
5. Click any pattern to insert it

## 🎭 Block Styles

### Available Block Styles
- **Hero Section**: For Group/Cover blocks
- **Card**: Styled containers with shadows
- **Service Grid**: Service showcase columns
- **Testimonial**: Quote styling for testimonials
- **Call to Action**: Gradient CTA sections
- **Outline Primary**: Outlined buttons
- **Ghost Button**: Transparent buttons
- **Rounded Button**: Circular button style
- **Rounded Image**: Circular image style
- **Shadow Image**: Images with drop shadows
- **Gradient Text**: Gradient text effects
- **Underlined Heading**: Headings with underlines
- **Checkmark List**: Lists with checkmark icons
- **No Bullets**: Clean lists without bullets

### Applying Block Styles
1. Select any block in the editor
2. Look for **Styles** in the block toolbar
3. Choose from available style options
4. Preview changes in real-time

## 📱 Responsive Design

GreenTech is built with a mobile-first approach:

- **Mobile**: Optimized for phones (320px+)
- **Tablet**: Perfect display on tablets (768px+)
- **Desktop**: Full layout on desktop (1024px+)
- **Large Screens**: Enhanced for large displays (1440px+)

## 🔍 SEO Features

### Built-in SEO Optimization
- **Clean HTML5**: Semantic markup for better search engine understanding
- **Structured Data**: Schema.org markup for organizations
- **Meta Tags**: Proper meta tag implementation
- **Fast Loading**: Optimized performance for better rankings
- **Mobile-Friendly**: Responsive design for mobile search rankings

### Recommended SEO Plugins
- **Yoast SEO**: Complete SEO optimization
- **RankMath**: Alternative SEO solution
- **All in One SEO**: Comprehensive SEO toolkit

## ⚡ Performance

### Optimization Features
- **Asset Optimization**: Minified CSS and JavaScript
- **Lazy Loading**: Images load only when needed
- **Font Display Swap**: Faster font loading
- **Preload Critical Resources**: Improved loading times
- **Clean Code**: Efficient PHP and JavaScript

### Performance Tips
1. **Use Caching**: Install a caching plugin like WP Rocket
2. **Optimize Images**: Use WebP format when possible
3. **CDN**: Consider using a Content Delivery Network
4. **Database Cleanup**: Regular database optimization

## 🌐 Browser Support

### Supported Browsers
- **Chrome**: 80+
- **Firefox**: 75+
- **Safari**: 13+
- **Edge**: 80+
- **Opera**: 67+

### Fallbacks
- Graceful degradation for older browsers
- Progressive enhancement for modern features
- Polyfills for essential functionality

## 🔧 Development

### File Structure
```
greentech-theme/
├── assets/
│   ├── css/           # Stylesheets
│   ├── js/            # JavaScript files
│   └── images/        # Theme images
├── inc/               # PHP classes
│   ├── class-theme-setup.php
│   ├── class-customizer.php
│   ├── class-assets.php
│   ├── class-block-styles.php
│   ├── class-block-patterns.php
│   └── class-admin.php
├── languages/         # Translation files
├── patterns/          # Block pattern files
├── styles/            # Block style definitions
├── template-parts/    # Template partials
├── functions.php      # Main functions file
├── style.css          # Main stylesheet
└── *.php             # Template files
```

### Hooks & Filters

#### Action Hooks
```php
// After theme setup
do_action('greentech_after_setup_theme');

// Before header
do_action('greentech_before_header');

// After header
do_action('greentech_after_header');

// Before footer
do_action('greentech_before_footer');

// After footer
do_action('greentech_after_footer');
```

#### Filter Hooks
```php
// Modify excerpt length
apply_filters('greentech_excerpt_length', 30);

// Modify read more text
apply_filters('greentech_read_more_text', 'Read More');

// Modify container width
apply_filters('greentech_container_width', 1200);
```

### Child Theme Support
Create a child theme for customizations:

```php
// style.css
/*
Theme Name: GreenTech Child
Template: greentech-theme
*/

@import url("../greentech-theme/style.css");

/* Your custom styles here */
```

## 🌍 Translation

### Available Languages
- English (default)
- Translation ready for all languages

### Creating Translations
1. Use the provided `greentech.pot` file
2. Create `.po` files for your language
3. Compile to `.mo` files
4. Place in `/languages/` directory

### Translation Tools
- **Poedit**: Popular translation editor
- **Loco Translate**: WordPress plugin for translations
- **WPML**: Multilingual website solution

## 🔒 Security

### Security Features
- **Nonce Verification**: All AJAX requests protected
- **Data Sanitization**: All user inputs sanitized
- **Escape Output**: All output properly escaped
- **Security Headers**: Added security headers
- **File Access Protection**: Direct file access prevented

### Security Best Practices
1. Keep WordPress and plugins updated
2. Use strong passwords
3. Install security plugins (Wordfence, Sucuri)
4. Regular backups
5. Monitor for malware

## 🐛 Troubleshooting

### Common Issues

#### Theme Not Displaying Correctly
1. Clear all caches
2. Check for plugin conflicts
3. Verify WordPress version compatibility
4. Review browser console for errors

#### Customizer Options Not Saving
1. Check file permissions
2. Increase PHP memory limit
3. Disable conflicting plugins
4. Contact hosting provider

#### Block Patterns Not Showing
1. Ensure WordPress 6.0+
2. Clear browser cache
3. Check for plugin conflicts
4. Verify theme activation

#### Performance Issues
1. Install caching plugin
2. Optimize images
3. Check hosting resources
4. Review installed plugins

### Getting Help
- **Documentation**: Check this README file
- **WordPress Forums**: Community support
- **Theme Support**: Contact theme developers
- **Professional Help**: Hire WordPress developer

## 📞 Support

### Theme Support Includes
- Installation assistance
- Basic customization help
- Bug fixes and updates
- Documentation updates

### What's Not Included
- Custom development
- Third-party plugin support
- Server configuration
- Content creation

### Contact Information
- **Email**: inquiry@greentech.guru
- **Website**: www.greentech.guru
- **Phone**: 0544-277588
- **Address**: Office# 11, 1st Floor Soldier Arcade, Al-Markaz Road, Jhelum

## 📄 License

GreenTech WordPress Theme is licensed under the GPL v2 or later.

This theme is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

## 🎯 Credits

### Resources Used
- **Google Fonts**: Inter and Poppins font families
- **WordPress**: Core functionality and block editor
- **Font Awesome**: Icon inspiration
- **Normalize.css**: CSS reset foundation

### Special Thanks
- WordPress community for continued development
- Block editor team for Gutenberg
- All beta testers and early adopters

## 📈 Changelog

### Version 1.0.0 (Initial Release)
- Complete Gutenberg-based theme
- 20+ custom block styles
- 8 professional block patterns
- Extensive customizer integration
- Modern OOP PHP architecture
- Full translation support
- Performance optimizations
- Accessibility compliance
- SEO-friendly structure
- Professional documentation

---

**Made with ❤️ for the WordPress community**

For more information, visit [www.greentech.guru](https://www.greentech.guru)