# GreenTech WordPress Theme

A modern, professional, and responsive WordPress theme designed specifically for web development agencies, hosting companies, SEO agencies, and software houses. Inspired by contemporary design patterns with clean typography and vibrant green accent colors.

## Features

### 🎨 Design
- **Modern & Professional**: Clean, contemporary design with vibrant green (#4CAF50) accent colors
- **Fully Responsive**: Optimized for all devices (desktop, tablet, mobile)
- **Clean Typography**: Inter font family with proper hierarchy and readability
- **Grid-Based Layout**: Organized content with ample spacing and clear visual hierarchy

### 🏠 Homepage Sections
- **Hero Section**: Full-width hero with customizable title, subtitle, and call-to-action buttons
- **Services Grid**: 4-column service cards with icons, descriptions, and hover effects
- **Portfolio Grid**: Filterable portfolio items with hover overlays and category filtering
- **Testimonials Carousel**: Client testimonials with photos and auto-rotation
- **Technology Logos**: Clean display of technology partners and certifications
- **Contact CTA**: Prominent call-to-action section with contact information
- **Latest Blog Posts**: Recent articles with featured images and excerpts

### 🔧 Built-in Services
- **Web & App Development**: Web Development, WordPress, Mobile Apps, ERP, Hosting & Cloud, Plugin Development
- **E-Commerce Development**: Shopify, Shopify Plus, Magento, BigCommerce, WooCommerce
- **Graphic Designing**: Logo & Branding, Print Design, Product Design, Banners & Ads, UI/UX Design
- **Digital Marketing**: Performance Marketing, TikTok Marketing, SEO, Influencer Marketing, Social Media, Email Marketing, CRO

### 💻 Technical Features
- **WordPress Best Practices**: Clean, secure, and optimized code
- **OOP PHP**: Object-oriented programming with namespaces
- **Custom Post Types**: Ready for portfolio items and service pages
- **SEO Optimized**: Structured data, semantic HTML, and fast loading
- **Customizer Integration**: Easy customization through WordPress Customizer
- **Translation Ready**: Full i18n support with .pot file
- **Widget Areas**: Sidebar and footer widget areas

## Installation

1. **Download the theme files** from this repository
2. **Upload to WordPress**:
   - Via Admin: Go to Appearance > Themes > Add New > Upload Theme
   - Via FTP: Upload the `greentech-theme` folder to `/wp-content/themes/`
3. **Activate the theme** in WordPress Admin > Appearance > Themes
4. **Customize** your site using the WordPress Customizer

## File Structure

```
greentech-theme/
├── assets/
│   ├── css/
│   ├── js/
│   │   └── main.js
│   └── images/
├── inc/
├── template-parts/
├── style.css
├── functions.php
├── index.php
├── header.php
├── footer.php
├── page.php
├── single.php
├── archive.php
├── sidebar.php
├── comments.php
├── 404.php
├── page-services.php
└── README.md
```

## Customization Options

### WordPress Customizer
Access **Appearance > Customize** to modify:

#### Colors
- **Primary Color**: Change the main accent color (default: #4CAF50)
- **Secondary Colors**: Automatically generated based on primary color

#### Contact Information
- **Phone Number**: Display phone number in header and footer
- **Email Address**: Contact email for forms and display
- **Address**: Business address for footer and contact sections
- **Website**: Business website URL

#### Hero Section
- **Hero Title**: Main headline text
- **Hero Subtitle**: Supporting text below the title
- **Button Text**: Call-to-action button text
- **Button URL**: Where the CTA button links to

#### Branding
- **Logo**: Upload your custom logo
- **Site Title**: Customize site title and tagline

### Menu Locations
- **Primary Menu**: Main navigation in header
- **Footer Menu**: Quick links in footer
- **Social Media Menu**: Social media links in footer

### Widget Areas
- **Sidebar**: Blog post sidebar
- **Footer Widget Area**: Footer content area

## Page Templates

### Homepage (index.php)
- Hero section with customizable content
- Services grid with 4 main service categories
- Portfolio grid with filtering functionality
- Testimonials carousel
- Technology logos section
- Contact call-to-action
- Latest blog posts

### Services Page (page-services.php)
- Detailed service descriptions
- Process workflow
- Call-to-action sections
- **To use**: Create a new page and select "Services Page" template

### Individual Posts (single.php)
- Featured image support
- Author bio section
- Related posts
- Comments system
- Social sharing ready

### Archive Pages (archive.php)
- Category, tag, and date archives
- Pagination
- Archive descriptions

## Customization & Development

### Adding New Services
Edit the `greentech_get_services()` function in `functions.php`:

```php
function greentech_get_services() {
    return [
        [
            'title' => 'Your Service Title',
            'description' => 'Service description',
            'icon' => '🚀', // Emoji or HTML
            'services' => ['Feature 1', 'Feature 2', 'Feature 3']
        ],
        // Add more services...
    ];
}
```

### Adding Portfolio Items
Edit the `greentech_get_portfolio()` function in `functions.php`:

```php
function greentech_get_portfolio() {
    return [
        [
            'title' => 'Project Title',
            'description' => 'Project description',
            'image' => 'path/to/image.jpg',
            'category' => 'category-slug',
            'tags' => ['Tag 1', 'Tag 2']
        ],
        // Add more portfolio items...
    ];
}
```

### Custom CSS
Add custom styles to **Appearance > Customize > Additional CSS** or create a child theme.

### Child Theme
Create a child theme to preserve customizations:

```php
// child-theme/style.css
/*
Theme Name: GreenTech Child
Template: greentech-theme
*/

@import url("../greentech-theme/style.css");

/* Your custom styles here */
```

## Browser Support

- **Chrome**: Latest
- **Firefox**: Latest
- **Safari**: Latest
- **Edge**: Latest
- **Internet Explorer**: 11+

## Performance

- **Optimized Assets**: Minified CSS and JavaScript
- **Lazy Loading**: Images load as needed
- **Caching Friendly**: Works with popular caching plugins
- **Fast Loading**: Optimized for Core Web Vitals

## SEO Features

- **Semantic HTML5**: Proper heading hierarchy and semantic elements
- **Schema Markup**: Structured data for better search visibility
- **Meta Tags**: Proper meta descriptions and Open Graph tags
- **Mobile Friendly**: Responsive design passes Google Mobile-Friendly Test

## Required Plugins

None required, but these are recommended:

- **Contact Form 7**: For contact forms
- **Yoast SEO**: For advanced SEO features
- **WP Super Cache**: For caching
- **Akismet**: For spam protection

## Support & Updates

This theme is designed to be easily customizable for different agencies. The codebase is well-documented and follows WordPress coding standards.

### Customization Services
For custom modifications or additional features, the theme architecture supports:
- Custom post types for services and portfolio
- Additional page templates
- WooCommerce integration
- Multi-language support
- Custom widgets

## License

GPL v2 or later - You're free to use, modify, and distribute this theme.

## Credits

- **Fonts**: Inter (Google Fonts)
- **Icons**: Custom SVG icons
- **Inspiration**: Modern web design trends and Clustox.com
- **Built with**: WordPress best practices and modern web technologies

## Contact Information

**GreenTech Digital Solutions**
- Address: Office# 11, 1st Floor Soldier Arcade, Al-Markaz Road, Jhelum
- Phone: 0544-277588
- Email: inquiry@greentech.guru
- Website: www.greentech.guru

---

*This theme is perfect for web development agencies, hosting companies, SEO agencies, and software houses looking for a professional, modern WordPress theme that converts visitors into clients.*