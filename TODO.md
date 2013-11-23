# TODO
----------------------

1. L'utente può arrivare da qualsiasi parte del mondo , di conseguenza con un fuso
   orario differente dal nostro server , dobbiamo assicurarci che lui abbia
   compiuto x anni.


  Esempio :

  Server in Italia (UTC +1)

  Io compio gli anni il 13 Agosto 1987.

  Accedo al sito dal Texas (UTC -6) il 12 Agosto alle ore 19.00 --> non ho compiuto gli anni

  Accedo al sito dal Texas (UTC -6) il 13 Agosto alle ore 00.01 --> ho compiuto gli anni


  Cosa mi serve?

  La timezone dell'utente oltre alla sua data di compleanno.
  La data odierna in UTC.


  GOALS :

  La data può essere passata al vaidatore come un oggetto \DateTime o come una stringa date standard
  che contiene la timezone dell'utente UTC!!!!





