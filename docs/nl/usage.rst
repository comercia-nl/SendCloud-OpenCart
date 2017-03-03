*******
Gebruik
*******

Orders transporteren naar SendCloud
===================================
Nu de extensie is geïnstalleerd kun je de orders naar SendCloud overzetten.
Ga naar je bestellingen in de OpenCart admin. ``Verkopen -> Orders``. 

Selecteer vervolgens de orders die je wilt overzetten en klik op de knop met het SendCloud logo. 

.. image:: ../images/extension_transport.png

Orders verwerken in SendCloud
=============================
Login in het `SendCloud Panel <https://panel.sendcloud.nl>`_  met uw SendCloud account.
In het blauwe top menu, selecteer het plug icoontje (als u meerdere integraties actief heeft, kunnen er meerdere icoontjes in deze balk staan, in dit geval kiest u het plug icoontje voor uw nieuw opgezette integratie).

.. image:: ../images/plug_icon.png

Op de overzichtspagina die toont nadat u op het plug icoontje heeft geklikt, vindt u de orders die verstuurd zijn via de SendCloud module vanuit uw OpenCart webshop.

.. image:: ../images/module_orders.png

Foutmeldingen
=============
.. image:: ../images/extension_error_shipping_details.png

Een of meerder orders heeft geen verzendgegevens (shipping details). Ga naar het detailoverzicht van de order en kijk of de verzendgegevens zijn ingevuld.
Let erop dat betalings gegevens niet hetzelfde zijn als de verzendgegevens. 

.. image:: ../images/extension_error_api_keys.png
 
Er is iets mis met de koppeling met SendCloud. de public key en/of secret key zijn misschien niet goed ingevuld. Kijk na of de keys hetzelfde zijn als in het `SendCloud Panel <https://panel.sendcloud.nl/>`_.
 
.. image:: ../images/extension_error_process.png

De orders kunnen niet overgezet worden naar SendCloud. Dit gebeurt wanneer er geen geschikte verzendmethode beschikbaar is voor de order.
Je kunt contact opnemen met het `SendCloud support team <contact@sendcloud.nl>`_ om te kijken of het mogelijk is om een geschikte verzendmethode te activeren.