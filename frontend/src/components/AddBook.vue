<template>
  <div class="form-container">
    <h1>Add a New Book</h1>
    <form @submit.prevent="validateForm">
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" v-model="book.title" placeholder="Enter the book title" required :class="{'is-invalid': titleError}">
      </div>
      <div class="form-group">
        <label for="author">Author:</label>
        <input type="text" v-model="book.author" @blur="validateAuthor" placeholder="Enter author's first and last name" required :class="{'is-invalid': authorError}">
        <span v-if="authorError" class="error">{{ authorError }}</span>
      </div>
      <div class="form-group">
        <label for="genre">Genre:</label>
        <input type="text" v-model="book.genre" placeholder="Enter the book genre" required>
      </div>
      <div class="form-group">
        <label for="published_year">Published Year:</label>
        <input type="number" v-model="book.published_year" placeholder="Enter the published year" required>
      </div>
      <div class="form-group">
        <label for="description">Description:</label>
        <div class="description-container">
          <textarea v-model="book.description" @blur="validateDescription" placeholder="Enter a description of at least 100 characters" required :class="{'is-invalid': descriptionError}"></textarea>
          <button type="button" @click="fetchDescription" class="ai-btn">Write with AI</button>
        </div>
        <span v-if="descriptionError" class="error">{{ descriptionError }}</span>
      </div>
      <button type="submit" :disabled="loading" class="btn">Create Book</button>
    </form>
    <p v-if="message" :class="{'success': success, 'error': !success}">{{ message }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      book: {
        title: '',
        author: '',
        genre: '',
        published_year: '',
        description: ''
      },
      loading: false,
      message: '',
      success: false,
      titleError: false,
      authorError: '',
      descriptionError: ''
    };
  },
  methods: {
    validateAuthor() {
      const authorRegex = /^[a-zA-Z]+ [a-zA-Z]+$/;
      if (!authorRegex.test(this.book.author)) {
        this.authorError = 'Author must be a first name and last name';
      } else {
        this.authorError = '';
      }
    },
    validateDescription() {
      if (this.book.description.length < 100) {
        this.descriptionError = 'Description must be at least 100 characters';
      } else {
        this.descriptionError = '';
      }
    },
    validateForm() {
      this.titleError = !this.book.title;
      this.validateAuthor();
      this.validateDescription();
      if (!this.titleError && !this.authorError && !this.descriptionError) {
        this.createBook();
      }
    },
    createBook() {
      this.loading = true;
      axios.post('http://localhost:8888/book_collections/books/create', this.book)
        .then(response => {
          console.log(response.data);
          this.message = 'Book created successfully!';
          this.success = true;
          // Reset the form fields
          this.book = {
            title: '',
            author: '',
            genre: '',
            published_year: '',
            description: ''
          };
        })
        .catch(error => {
          console.error('There was an error!', error);
          this.message = 'There was an error creating the book.';
          this.success = false;
        })
        .finally(() => {
          this.loading = false;
        });
    },
    fetchDescription() {
    const openAIEndpoint = 'https://api.openai.com/v1/chat/completions';
    const apiKey = 'YOUR OPANAI API KEY';
    const prompt = `Generate a detailed description (greater than 100 characters) for a book with the following details:
  - Title: ${this.book.title}
  - Author: ${this.book.author}
  - Genre: ${this.book.genre}, if Title, Author, or Genre is not provided, please just return 'You need to provide Title, Author and Genre to generate description'.`;

    this.loading = true;
    axios.post(openAIEndpoint, {
      model: "gpt-3.5-turbo",
      messages: [
        {role: "system", content: "You are a helpful assistant."},
        {role: "user", content: prompt}
      ],
      max_tokens: 150
    }, {
      headers: {
        'Authorization': `Bearer ${apiKey}`,
        'Content-Type': 'application/json'
      }
    })
    .then(response => {
      this.book.description = response.data.choices[0].message.content.trim();
    })
    .catch(error => {
      console.error('There was an error fetching the description!', error);
      this.message = 'There was an error fetching the description.';
      this.success = false;
    })
    .finally(() => {
      this.loading = false;
    });
   }
}
};
</script>

<style scoped>
.form-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  font-family: 'Arial', sans-serif;
  color: #333;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  font-family: 'Arial', sans-serif;
}

input, textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-family: 'Arial', sans-serif;
}

textarea {
  resize: vertical;
}

.description-container {
  display: flex;
  align-items: center;
}

textarea {
  flex-grow: 1;
}

.ai-btn {
  margin-left: 10px;
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-family: 'Arial', sans-serif;
}

.is-invalid {
  border-color: red;
}

.btn {
  display: block;
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  font-family: 'Arial', sans-serif;
}

.btn:disabled {
  background-color: #ccc;
}

.error {
  color: red;
  font-size: 14px;
}

.success {
  color: green;
  text-align: center;
  margin-top: 20px;
}

.error {
  color: red;
  text-align: center;
  margin-top: 20px;
}

/* Responsive Styles */
@media (max-width: 600px) {
  .form-container {
    padding: 10px;
  }

  h1 {
    font-size: 24px;
  }

  .btn {
    font-size: 14px;
  }
}
</style>
