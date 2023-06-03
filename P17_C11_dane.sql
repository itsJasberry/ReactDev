SELECT * FROM dbo.Uzytkownik;
GO

INSERT INTO dbo.Uzytkownik
(Imie, Nazwisko, Konto, Haslo, DataZarejestrowania)
VALUES
('Arya', 'Stark', 'arya9', '$2y$10$SaQvqoxvfdtLmLwBjn/cnuPCcuUJT.RFFW1XyIPgpPZxWAPBn5BGG', GETDATE()),
('Rick', 'Sanchez', 'rickandmorty', '$2y$10$0SyMsLlRx6mF5cK3dlzK2.j4jO7OkJGrNdiR7Ot4no3KeXOwOnkg6', GETDATE())
GO