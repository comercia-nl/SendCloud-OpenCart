******************************
Building the extension package
******************************

Getting a complete package is not as easy as cloning or downloading the repository.
You need to perform serveral steps to build a folder with all files for installing and the documentation.

::

	WARNING: If you're using Windows, Cygwin is highly recommended!

Installing prerequisites
========================

To build the package you need the following:

* Python 2.7
* Linux/UNIX command line or Cygwin (Windows) with ``CURL`` and ``GNU MAKE``

The documentation is build with Sphinx and rst2pdf. 
Because rst2pdf is Python 2.x only and because we use >= Python 2.7 commands you need a Python 2.7 interpreter.

The best way to setup the Python environment is to setup a correct Python enviroment with all the required packages is to create a virtualenv.

1.  Install virtualenv
----------------------
If you don't have virtualenv installed yet install it by using:

``pip install virtualenv``

**Note:** You need pip to install packages. Install pip by following this guide: `Guide to install pip <http://pip.readthedocs.org/en/latest/installing.html>`_ 

2.  Setup a virtualenv for building the Extension and documentation
-------------------------------------------------------------------

* First move to the location where you want to place the virtualenv. You can do this in the root of the project. The env/ directory is ignored by git.
* Create the virtual environment ``virtualenv env``
* Activate the environment ``. env/Scripts/activate`` (Cygwin) or ``source env/bin/activate`` (Linux/Mac OSX)
* Check if your virtualenv is activated. You should see ``(env)`` before your command input.
* Install *Sphinx* and *rst2pdf*: ``pip install -r requirements.txt``


Get the repository
==================

You now need to download or ``git clone`` the respository.
Move it to a location which you prefer to continue with.

Building the Extension
======================

#. Move into the extension's folder root.
#. Be sture that you have activated the virtual environment.
#. Execute ``make build``.
#. See if the extension is build in the ``dist/`` folder.