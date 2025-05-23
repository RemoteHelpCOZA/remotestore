# Remote Store WordPress Theme - Setup Guide

This guide will help you set up the Remote Store WordPress theme with the recommended configuration and sample data.

## Requirements

- WordPress 5.6 or higher
- PHP 7.4 or higher
- WooCommerce 5.0 or higher

## Theme Installation

1. Log in to your WordPress admin dashboard.
2. Go to **Appearance > Themes > Add New > Upload Theme**.
3. Click on "Choose File" and select the `remotestore.zip` file.
4. Click "Install Now" and then "Activate" once installation is complete.

## Required Plugins

The theme requires WooCommerce to be installed. Upon theme activation, you'll be prompted to install and activate the following plugins:

- WooCommerce (required)
- Elementor (optional, for additional page building features)
- Contact Form 7 (optional, for contact forms)
- YITH WooCommerce Wishlist (optional)
- YITH WooCommerce Compare (optional)

Click "Begin installing plugins" to install all the recommended plugins.

## Importing Sample Data

The theme includes sample data to help you quickly set up your store with the same look and structure as the demo.

### Import Steps:

1. Make sure WooCommerce is installed and activated
2. Go to **Tools > Import** in your WordPress admin
3. Click on "WordPress" (at the bottom of the importers list)
4. If prompted, install the WordPress Importer plugin
5. Choose the file `remotestore-sample-data.xml` from the theme folder
6. Click "Upload file and import"
7. When prompted, select "Download and import file attachments"
8. Assign the imported content to an existing user or create a new one
9. Click "Submit" to begin the import process

## Setting Up Pages

After importing the sample data, verify that the following pages are correctly assigned:

1. Go to **Settings > Reading**
2. Ensure "Your homepage displays" is set to "A static page"
3. Set "Homepage" to "Home"
4. Set "Posts page" to "Blog"

## WooCommerce Pages

Verify WooCommerce pages are correctly assigned:

1. Go to **WooCommerce > Settings > Advanced > Page Setup**
2. Ensure these pages are set correctly:
   - Shop page: "Shop"
   - Cart page: "Cart"
   - Checkout page: "Checkout"
   - My account page: "My Account"

## Menu Setup

The sample data includes pre-configured menus, but you should verify they're assigned to the correct locations:

1. Go to **Appearance > Menus**
2. For each menu (Primary Menu, Secondary Menu, Footer Menu), check the "Display location" section
3. Ensure they're assigned to the proper locations in the theme

## Theme Customization

Customize your theme appearance:

1. Go to **Appearance > Customize**
2. Explore the various sections to customize:
   - Header Options (logo, phone number)
   - Footer Options (copyright text, payment icons)
   - Homepage Sections (hero section, features, product categories, etc.)
   - Colors and fonts

## Adding Products

If you didn't import the sample products or want to add your own:

1. Go to **Products > Add New**
2. Fill in the product details (name, description, price, etc.)
3. Assign the product to appropriate categories
4. Add product images
5. Set additional options like sale price, stock status, etc.
6. Publish your product

## Featured Categories and Products

To set up featured categories for the homepage:

1. Go to **Products > Categories**
2. Edit a category
3. Scroll down to find "Feature this category on homepage" and check the box
4. Set a "Display Order" to control the position
5. Update the category

## Customizing Homepage Sections

The theme customizer lets you control which sections appear on the homepage:

1. Go to **Appearance > Customize > Homepage Sections**
2. Toggle sections on/off using the checkboxes
3. Customize content for each section
4. For product sections, select which categories or specific products to display

## Support and Questions

If you have any questions or need assistance setting up your theme, please contact our support team at support@remotehelp.co.za.

---

Enjoy your new Remote Store WordPress theme!
