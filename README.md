# Save PDF attachments to your disk

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Authors sometimes supplement their documents with additional electronic resources. For example, a document that displays large tables of data might also provide the reader with a matching Excel spreadsheet to work with. PDF's file attachment feature is an open-ended mechanism for packing any electronic file into a PDF like this. These attachments can be associated with the overall document or with individual pages. You can unpack PDF attachments to your disk using Acrobat, Reader, or this unpack-pdf-attachments package. After unpacking an attachment, you can view and manipulate it independently from the PDF document.

## Requirements
Behind the scenes this package leverages [PDFtk](https://www.pdflabs.com/tools/pdftk-the-pdf-toolkit). You can verify if the binary is installed on your system by running this command:

```bash
which pdftk
```

If it is installed, it will return the path to the binary.

To install the binary you can use this command on Ubuntu or Debian:

```bash
sudo snap install pdftk
```

## Installation
You can install this package via [Composer](http://getcomposer.org). Run the following command:

```bash
composer require einfacharchiv/unpack-pdf-attachments
```

## Usage
Unpacking attachments from a PDF is easy.

By default, this package unpacks all PDF attachments into the same directory.

```php
(new Pdf())
    ->setPdf('document.pdf')
    ->unpack();
```

Or easier:

```php
Pdf::unpackAttachments('document.pdf');
```

Sometimes you may want to use [pdftk options](https://www.pdflabs.com/docs/pdftk-man-page). To do so you can set them up using the `setOptions` method.

```php
(new Pdf())
    ->setPdf('document.pdf')
    ->setOptions(['output tmp'])
    ->unpack();
```

Or as the second parameter to the `unpackAttachments` static method:

```php
Pdf::unpackAttachments('document.pdf', ['output tmp']);
```

If the `pdftk` command is located elsewhere, pass its binary path to the constructor:

```php
(new Pdf('/snap/bin/pdftk'))
    ->setPdf('document.pdf')
    ->unpack();
```

Or as the third parameter to the `unpackAttachments` static method:

```php
Pdf::unpackAttachments('document.pdf', [], '/snap/bin/pdftk');
```

## Contributing
Contributions are **welcome**.

We accept contributions via Pull Requests on [Github](https://github.com/einfachArchiv/unpack-pdf-attachments).

Find yourself stuck using the package? Found a bug? Do you have general questions or suggestions for improvement? Feel free to [create an issue on GitHub](https://github.com/einfachArchiv/unpack-pdf-attachments/issues), we'll try to address it as soon as possible.

If you've found a security issue, please email [support@einfacharchiv.com](mailto:support@einfacharchiv.com) instead of using the issue tracker.

**Happy coding**!

## Credits
- [Philip Günther](https://github.com/Pag-Man)
- [All Contributors](https://github.com/einfachArchiv/unpack-pdf-attachments/contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
