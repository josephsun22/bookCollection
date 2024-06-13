USE book_collections;
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    genre VARCHAR(255) NOT NULL,
    published_year YEAR NOT NULL,
    description TEXT
);

INSERT INTO books (title, author, genre, published_year, description) VALUES
('The Great Adventure', 'John Smith', 'Adventure', 2021, 'An epic tale of adventure and discovery, where a young hero embarks on a journey across uncharted lands to uncover hidden secrets and treasures.'),
('Mystery at the Manor', 'Jane Doe', 'Mystery', 2019, 'A gripping mystery set in an old manor, where dark secrets and unexpected twists keep readers on the edge of their seats as they follow the investigation.'),
('Love in the Time of Algorithms', 'Alice Johnson', 'Romance', 2020, 'A modern love story involving AI and technology, exploring the complexities of human relationships in the digital age and the impact of artificial intelligence on our hearts.'),
('The Future of Humanity', 'Isaac Asimov', 'Science Fiction', 1986, 'A visionary look at the future of the human race, examining potential advancements and ethical dilemmas as humanity pushes the boundaries of science and technology.'),
('Cooking with Passion', 'Gordon Ramsay', 'Cooking', 2015, 'Delicious recipes and culinary tips from a master chef, providing readers with the inspiration and skills needed to create extraordinary meals and elevate their cooking.'),
('The History of the World', 'David Attenborough', 'History', 2005, 'A comprehensive history of the world from ancient to modern times, detailing significant events, cultures, and civilizations that have shaped our global heritage.'),
('The Art of War', 'Sun Tzu', 'Philosophy', -500, 'Ancient Chinese military treatise on strategy and tactics, offering timeless wisdom on leadership, conflict resolution, and the art of achieving victory without fighting.'),
('Gardening for Beginners', 'Martha Stewart', 'Gardening', 2018, 'A complete guide to starting your own garden, covering everything from soil preparation to plant selection, and offering practical advice for cultivating a thriving and beautiful garden.'),
('The Mindful Way', 'Jon Kabat-Zinn', 'Self-help', 2007, 'A guide to mindfulness and meditation for a better life, teaching readers how to cultivate awareness, reduce stress, and enhance overall well-being through mindful practices.'),
('The Ultimate Travel Guide', 'Rick Steves', 'Travel', 2013, 'Essential tips and destinations for travelers around the world, providing insider knowledge and recommendations for unforgettable journeys and cultural experiences.');
