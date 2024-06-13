# README

# 📖 Simple Book Collection Web Application 🔥

## 🖥️ Technologies:

- Frontend: Vue 2.6.14
- Backend: CodeIgniter 3.1.13
- Database: MySQL 5.7.39

## 📺 Demo Video:
https://youtu.be/oq0Ucwktsq0

## How to Run

### Step 1: Set Up MAMP

1. Download and install MAMP from https://www.mamp.info/en/downloads/.
2. Open MAMP and set Apache port → 8888, MySQL port → 8889 in preferences tab.

### Step 2: Set Up Project Files

1. Clone source code from repository.

```bash
git clone https://github.com/josephsun22/bookCollection.git
```

1. Rename the source code foler name to **book_collections.**
2. Move the folder **book_collections** to MAMP `htdocs` directory (e.g., `/Applications/MAMP/htdocs/book_collections`). 


### Step 3: Set Up Vue 2

1. Go to `/Applications/MAMP/htdocs/book_collections/frontend` and install dependencies:
2. Make sure node.js already installed in your computer, then run:

```bash
npm cache clean --force
rm package-lock.json
npm install
```

### Step 4: Set Up Database

- **Run CodeIgniter Server:**
    - Start the servers (Apache and MySQL) in MAMP.
- Go to [http://localhost:8888/phpMyAdmin5/](http://localhost:8888/phpMyAdmin5/), create a database named **book_collections.**
- Run SQL queries in phpMyAdmin:

```sql
-- Create schema
USE book_collections;
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    genre VARCHAR(255) NOT NULL,
    published_year YEAR NOT NULL,
    description TEXT
);

-- Create dummy records
INSERT INTO books (title, author, genre, published_year, description) VALUES
('The Great Adventure', 'John Smith', 'Adventure', 2021, 'An epic tale of adventure and discovery, where a young hero embarks on a journey across uncharted lands to uncover hidden secrets and treasures.'),
('Mystery at the Manor', 'Jane Doe', 'Mystery', 2019, 'A gripping mystery set in an old manor, where dark secrets and unexpected twists keep readers on the edge of their seats as they follow the investigation.'),
('Love in the Time of Algorithms', 'Alice Johnson', 'Romance', 2020, 'A modern love story involving AI and technology, exploring the complexities of human relationships in the digital age and the impact of artificial intelligence on our hearts.'),
('The Future of Humanity', 'Isaac Asimov', 'Science Fiction', 1986, 'A visionary look at the future of the human race, examining potential advancements and ethical dilemmas as humanity pushes the boundaries of science and technology.'),
('Cooking with Passion', 'Gordon Ramsay', 'Cooking', 2015, 'Delicious recipes and culinary tips from a master chef, providing readers with the inspiration and skills needed to create extraordinary meals and elevate their cooking.'),
('The History of the World', 'David Attenborough', 'History', 2005, 'A comprehensive history of the world from ancient to modern times, detailing significant events, cultures, and civilizations that have shaped our global heritage.'),
('The Art of War', 'Sun Tzu', 'Philosophy', 2010, 'Ancient Chinese military treatise on strategy and tactics, offering timeless wisdom on leadership, conflict resolution, and the art of achieving victory without fighting.'),
('Gardening for Beginners', 'Martha Stewart', 'Gardening', 2018, 'A complete guide to starting your own garden, covering everything from soil preparation to plant selection, and offering practical advice for cultivating a thriving and beautiful garden.'),
('The Mindful Way', 'Jon Kabat-Zinn', 'Self-help', 2007, 'A guide to mindfulness and meditation for a better life, teaching readers how to cultivate awareness, reduce stress, and enhance overall well-being through mindful practices.'),
('The Ultimate Travel Guide', 'Rick Steves', 'Travel', 2013, 'Essential tips and destinations for travelers around the world, providing insider knowledge and recommendations for unforgettable journeys and cultural experiences.');
```

### Final Steps:

- **Run Vue.js App:**
    - Navigate to your Vue project directory(e.g. `/Applications/MAMP/htdocs/book_collections/frontend`) and start the development server:
        
        ```bash
        npm run serve
        ```
        
- **Access Your App:**
    - Open your browser and navigate to `http://localhost:8080` (or the port shown in your terminal) to see your Vue.js frontend interacting with your CodeIgniter backend

# Challenges & Solutions

### Setting CI3 Router

**Challenge:** 

As specified in the instructions, the router url below will serve two kinds of http requests(GET, POST), however, the CI3 router doesn’t allow setting http request method in routes.php.

```php
GET /books/{id} → Books::get_book
POST /books/{id} → Books::update_book
$route['books/(:num)']['post'] = 'books/update_book/$1'; // NOT ALLOWED IN CI3
```

**Solution:**

Setting a **handle_book** function to handle different http request method

```php
// routes.php
$route['books/(:num)'] = 'books/handle_book/$1'; // GET, POST /books/{id}

// Books.php controller
public function handle_book($id) {
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            $this->get_book($id);
            break;
        case 'POST':
            $this->update_book($id);
            break;
        default:
            $this->output
                ->set_status_header(405)
                ->set_output(json_encode(['error' => 'Method not allowed']));
            break;
    }
}
```

---

### Cross-Origin Resource Sharing (CORS) issues

**Challenges:** 

If  Vue.js application is running on http://localhost:8080 and your CI3 backend is on http://localhost:8888, CORS comes into play.

**Solution:**

- Add a CORS Helper and load the helper in controller's constructor.
- Add CORS headers in the server configuration.

---

### Validation and Error Handling

**Challenges:**

Unsure this feature should be implemented on both frontend and backend or not.

**Solution:**

Use Both Frontend and Backend Validation for best practices:

1. Frontend (Vue2): For improving user experience and providing instant feedback.
2. Backend (CodeIgniter3): For ensuring security and data integrity.

---

### Unnecessary URL Segment

**Challenges:**

To access controllers other than default ,like a controller named `Books.php` , you can access them like this:

```php
http://localhost:8888/book_collections/index.php/books
```

I’d like to remove `index.php` from URLs for cleaner access.

**Solution:**

Update `.htaccess` file is properly configured:

```php
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /book_collections/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

---

### **Problem Accessing book id when loading book detail page**

**Solution:**

Set props attribute to true in vue router:

```jsx
{
    path: '/book_detail/:id',
    name: 'BookDetail',
    component: BookDetail,
    props: true, // Enables passing route params as props to the component
  }
```

## Check List:

- Books controller : All functions implemented, cerate and update method were called via AJAX.
- Book_model: All methods implemented, all SQL queries are built with CI3 query builder functions.
- Routes:  All routes are set as required.
- Frontend Pages: 3 pages are all built in Vue app.
    - List all books: [http://localhost:8080/](http://localhost:8080/) (Read)
    - Add new book: [http://localhost:8080/add](http://localhost:8080/add) (Create)
    - View & Edit & Delete book: Access by clicking cards on List all books page.(Read, Update, Delete)
- Validation and Error Handling implemented on both frontend and backend.
- Used both Axios and native fetch method to make API calls.
- Database set properly, all server side logic implemented.
- UI is clean, user-friendly and responsive.

## Extra AI feature:
- Get AI-generated description when adding new book.
- By calling OpenAI text generation API.
- API key is enclosed in email submission, feel free to have a try.
- Replace apikey in fronted -> src -> components -> AddBook.vue -> fetchDescription() -> apiKey.

# 😊 Thank you for your time viewing my work
