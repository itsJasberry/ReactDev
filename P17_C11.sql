----------------------------------------------------------------
-- PSIN_C11: uwierzytelnianie u�ytkownika
-- i zarz�dzenie jego sesj�
----------------------------------------------------------------
-- Definicja tabeli przechowuj�cej dane kont u�ytkownik�w 
CREATE TABLE dbo.Uzytkownik
(
IdUzytkownik int IDENTITY(1,1) NOT NULL PRIMARY KEY,
Imie varchar(30) NOT NULL,
Nazwisko varchar(40) NOT NULL,
Konto varchar(30) NOT NULL,
Haslo varchar(100) NOT NULL,
DataZarejestrowania datetime NOT NULL
);
GO
ALTER TABLE dbo.Uzytkownik
ADD CONSTRAINT UN_Uzytkownik_Konto
UNIQUE (Konto);
GO
-- Wstawienie danych przyk�adowych kont u�ytkownik�w
INSERT dbo.Uzytkownik
(Imie, Nazwisko, Konto, Haslo, DataZarejestrowania)
VALUES
('Arya', 'Stark', 'arya9', ' $2y$10$4pxoal4G7EJPkbP3WolhRePcwR8MQjAHIHNWPomQqaspqXu.PjgLC', GETDATE()),
('Tormund', 'Giantsbane', 'tormbrienne', '$2y$10$/ppowx8vlUDBWPiQyTn7WeyybWU9jGYwrrB3psg/sI1hs2qgE7QrS', GETDATE());
GO

SELECT * FROM dbo.Uzytkownik;
GO


----------------------------------------------------------------
-- Polecenie wybieraj�ce wiersze - SELECT.
----------------------------------------------------------------
--


