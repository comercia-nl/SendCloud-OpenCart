************
Installation
************

**Notice!** A SendCloud account is required to use this extension. You can request one for free `here <https://www.sendcloud.nl/aanmelden/?r=OpenCartDocs>`_.

1.  Download the SendCloud Extension
====================================
The easiest way to to get the module is to get it from the OpenCart extension store:

.. include:: ../../README.rst
	:start-after: Extension Store:
	:end-before: SendCloud

2.  Extract the SendCloud Extension
===================================
Extract the OpenCart extension to a location at your computer.

.. image:: ../images/unzip.png
 
3.  Installing vQmod
====================
If you’ve already installed vQmod you can skip this step and go to :ref:`step 4 <step-four>`.

1. Download latest version of vQmod for OpenCart from GitHub.
	https://github.com/vqmod/vqmod/releases

2. The easiest way to install vQmod is with this instruction video.
	http://youtu.be/ezS1jWoMmjc

3. Or follow this guide on GitHub.
	https://github.com/vqmod/vqmod/wiki/Installing-vQmod-on-OpenCart

.. _step-four:

4.  Upload the SendCloud Extension
==================================
Connect to your website with your favorite FTP client. If you don’t have any you can use `FileZilla <https://filezilla-project.org/>`_.

Upload the files from the ``upload`` folder from the extension package to your website.

.. image:: ../images/upload.png
 
5.  Get SendCloud API keys
==========================
Login on the `SendCloud Panel <https://panel.sendcloud.nl>`_  with your SendCloud account.  Choose ``Settings (Instellingen) -> API``.

.. image:: ../images/api_keys.png

Copy your public and secret key. 

7.  Activate the SendCloud Extension
====================================
Login to the OpenCart admin area. Go to ``Extensions -> Modules`` and click on the green button from the SendCloud Extension.

.. image:: ../images/extension_install.png
 
The SendCloud Extension is activated.

8.  Setup the SendCloud Extension
=================================
Click on the blue edit button.

.. image:: ../images/extension_edit.png
 
Insert your API public & secret key. Choose your order state and save the settings.