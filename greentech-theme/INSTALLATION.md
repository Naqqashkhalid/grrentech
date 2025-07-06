# GreenTech WordPress Theme - Installation & Setup Guide

## Quick Start

### 1. Download & Install
1. Download the theme files from the repository
2. Upload the `greentech-theme` folder to `/wp-content/themes/`
3. Activate the theme from WordPress Admin → Appearance → Themes

### 2. Required Setup
1. **Set Homepage**: Go to Settings → Reading → Set a static page as homepage
2. **Create Menus**: Go to Appearance → Menus → Create and assign menus
3. **Configure Theme**: Go to Appearance → Customize → GreenTech Options

## Detailed Installation Steps

### Step 1: WordPress Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher
- Modern web browser

### Step 2: Theme Installation

#### Method 1: Direct Upload
1. Download the theme ZIP file
2. Go to WordPress Admin → Appearance → Themes
3. Click "Add New" → "Upload Theme"
4. Select the theme ZIP file and click "Install Now"
5. Click "Activate" once installed

#### Method 2: FTP Upload
1. Extract the theme files
2. Upload the `greentech-theme` folder to `/wp-content/themes/`
3. Go to WordPress Admin → Appearance → Themes
4. Find "GreenTech" and click "Activate"

### Step 3: Initial Configuration

#### 3.1 Homepage Setup
1. Go to **Pages → Add New**
2. Create a new page titled "Home"
3. Set the page template to "Homepage Template" (if available)
4. Go to **Settings → Reading**
5. Select "A static page" under "Your homepage displays"
6. Choose "Home" as your homepage

#### 3.2 Menu Configuration
1. Go to **Appearance → Menus**
2. Create a new menu named "Primary Menu"
3. Add pages: Home, About, Services, Portfolio, Contact
4. Assign to "Primary Menu" location
5. Save the menu

#### 3.3 Logo Upload
1. Go to **Appearance → Customize**
2. Select "Site Identity"
3. Upload your logo image
4. Set site title and tagline
5. Click "Publish"

### Step 4: Theme Customization

#### 4.1 Color Scheme
1. Go to **Appearance → Customize → GreenTech Options → Colors**
2. Set Primary Color (default: #4CAF50)
3. Set Secondary Color (default: #1a1a1a)
4. Click "Publish"

#### 4.2 Hero Section
1. Go to **Appearance → Customize → GreenTech Options → Hero Section**
2. Set Hero Title
3. Set Hero Subtitle
4. Configure button text and URLs
5. Click "Publish"

#### 4.3 Contact Information
1. Go to **Appearance → Customize → GreenTech Options → Contact Info**
2. Enter your business details:
   - Phone: 0544-277588
   - Email: inquiry@greentech.guru
   - Address: Office# 11, 1st Floor Soldier Arcade, Al-Markaz Road, Jhelum
   - Website: www.greentech.guru
3. Click "Publish"

#### 4.4 Social Media
1. Go to **Appearance → Customize → GreenTech Options → Social Media**
2. Enter your social media URLs
3. Click "Publish"

### Step 5: Content Setup

#### 5.1 Create Essential Pages
Create these pages with the following content:

**About Page:**
- Title: "About Us"
- Content: Your company information

**Services Page:**
- Title: "Our Services"
- Use the page template "Services Page Template"

**Portfolio Page:**
- Title: "Our Work"
- Use the page template "Portfolio Page Template"

**Contact Page:**
- Title: "Contact Us"
- Add contact form and business information

#### 5.2 Portfolio Items
1. Go to **Portfolio → Add New**
2. Create portfolio items with:
   - Title and description
   - Featured image
   - Project details
   - Category assignment

#### 5.3 Services
1. Go to **Services → Add New**
2. Create service items with:
   - Service title and description
   - Service icon/image
   - Service details
   - Category assignment

#### 5.4 Blog Posts
1. Go to **Posts → Add New**
2. Create blog content with:
   - Featured images
   - Categories and tags
   - SEO-friendly content

### Step 6: Advanced Configuration

#### 6.1 Widgets
1. Go to **Appearance → Widgets**
2. Configure sidebar widgets
3. Add footer widgets

#### 6.2 Customizer Options
Explore all customization options in **Appearance → Customize**:
- **Colors**: Primary and secondary colors
- **Typography**: Font selections
- **Header**: Header styles and options
- **Hero Section**: Homepage hero content
- **Contact Info**: Business details
- **Social Media**: Social network links
- **Footer**: Footer content and layout
- **Blog**: Blog layout options

### Step 7: Performance Optimization

#### 7.1 Recommended Plugins
Install these plugins for optimal performance:
- **Yoast SEO**: For search engine optimization
- **WP Super Cache**: For caching
- **Contact Form 7**: For contact forms
- **Wordfence**: For security
- **WP Smush**: For image optimization

#### 7.2 Image Optimization
1. Upload images in appropriate sizes:
   - Hero images: 1920x800px
   - Portfolio images: 800x600px
   - Blog images: 1200x800px
2. Use WebP format when possible
3. Compress images before uploading

### Step 8: SEO Setup

#### 8.1 Basic SEO
1. Install Yoast SEO plugin
2. Configure site title and meta description
3. Set up Google Analytics
4. Create XML sitemap

#### 8.2 Content SEO
1. Use proper heading structure (H1, H2, H3)
2. Add alt text to all images
3. Write descriptive meta descriptions
4. Use internal linking

### Step 9: Testing & Launch

#### 9.1 Pre-Launch Checklist
- [ ] Test on mobile devices
- [ ] Test all forms and functionality
- [ ] Check all menu links
- [ ] Verify contact information
- [ ] Test page loading speed
- [ ] Check cross-browser compatibility

#### 9.2 Launch Tasks
1. Remove "Coming Soon" or maintenance mode
2. Submit site to Google Search Console
3. Set up Google Analytics
4. Create backup of the site
5. Monitor site performance

## Troubleshooting

### Common Issues

#### Theme Not Activating
- Check PHP version (minimum 7.4)
- Verify file permissions
- Check for plugin conflicts

#### Images Not Displaying
- Verify image file paths
- Check file permissions
- Ensure images are uploaded correctly

#### Customizer Not Working
- Clear browser cache
- Disable conflicting plugins
- Check for JavaScript errors

#### Performance Issues
- Install caching plugin
- Optimize images
- Minimize active plugins
- Use CDN service

### Getting Help

#### Support Resources
- **Documentation**: README.md file
- **WordPress Codex**: https://codex.wordpress.org/
- **Community Forums**: WordPress.org forums

#### Contact Support
- **Email**: inquiry@greentech.guru
- **Phone**: 0544-277588
- **Website**: www.greentech.guru

## Maintenance

### Regular Tasks
1. **Update WordPress**: Keep WordPress core updated
2. **Update Plugins**: Regularly update all plugins
3. **Backup Site**: Create regular backups
4. **Monitor Performance**: Check site speed and uptime
5. **Review Analytics**: Monitor site traffic and user behavior

### Monthly Tasks
1. **Security Scan**: Run security scans
2. **Broken Link Check**: Check for broken links
3. **Content Review**: Update outdated content
4. **SEO Audit**: Review SEO performance

## Customization

### Child Theme Setup
For custom modifications, create a child theme:

1. Create folder: `greentech-child`
2. Create `style.css`:
```css
/*
Theme Name: GreenTech Child
Template: greentech-theme
*/

@import url("../greentech-theme/style.css");

/* Your custom styles here */
```

3. Create `functions.php`:
```php
<?php
function greentech_child_enqueue_styles() {
    wp_enqueue_style('greentech-parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'greentech_child_enqueue_styles');
```

### Custom CSS
Add custom styles via:
1. **Appearance → Customize → Additional CSS**
2. **Child theme style.css**
3. **Plugin like "Easy Custom CSS"**

### Hooks and Filters
The theme provides various hooks for customization:
- `greentech_header_before`
- `greentech_header_after`
- `greentech_footer_before`
- `greentech_footer_after`
- `greentech_services_data`
- `greentech_portfolio_data`

## Updates

### Theme Updates
1. **Backup**: Always backup before updating
2. **Test**: Test updates on staging site first
3. **Child Theme**: Use child theme for customizations
4. **Documentation**: Keep track of customizations

### Version History
- **1.0.0**: Initial release with full B2B design implementation

---

**Built with ❤️ by GreenTech Development Team**

For more information, visit [www.greentech.guru](http://www.greentech.guru)