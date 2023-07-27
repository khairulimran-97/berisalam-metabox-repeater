# Code Snippet - Recurring Donation Meta Box

This code snippet adds a meta box to the admin area for a custom post type called "product". The meta box allows users to add recurring donation options to the product.

## Usage

1. Install and activate the [Code Snippets](https://wordpress.org/plugins/code-snippets/) plugin from the WordPress plugin repository.
2. In your WordPress admin panel, navigate to "Snippets" under the "Plugins" menu.
3. Click on "Add New" to create a new code snippet.
4. Give your snippet a name (e.g., "Recurring Donation Meta Box").
5. Paste the provided code into the "Code" box.
6. Click on "Save Changes and Activate" to save and activate the code snippet.

## Customization

You can customize the code snippet to fit your specific needs. Here are some areas you may want to modify:

- Meta box title: You can change the title of the meta box by modifying the `'Recurring Donation - Berisalam'` parameter in the `add_meta_box` function call.
- Post type: By default, the meta box is added to the `'product'` post type. If you want to add it to a different post type, you can modify the `'product'` parameter in the `add_meta_box` function call.
- Donation fields: The code snippet includes fields for weekly and monthly donation URLs, as well as repeatable donation fields. You can modify the HTML markup and field names/values to match your specific requirements.

## Contributing

Contributions are welcome! If you have any suggestions, improvements, or bug fixes, feel free to open an issue or submit a pull request on the [GitHub repository](https://github.com/your-username/your-repository).

## License

This code snippet is licensed under the [MIT License](https://opensource.org/licenses/MIT).
