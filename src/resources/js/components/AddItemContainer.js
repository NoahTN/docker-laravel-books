import React, { useEffect, useState } from 'react';

function AddItemContainer(props) {
    const [books, setBooks] = useState([]);

    function handleSubmit(e) {
        e.preventDefault();
        props.handleAddBook({title: e.target.title.value, author: e.target.author.value});
    }

    useEffect(() => {
    }, []);

    return <form onSubmit={handleSubmit}>
        <div className="input-container">
            <label htmlFor="title" className="required-field">Title</label>
            <input required name="title" title="A title is required"/>
        </div>
        <div className="input-container">
            <label htmlFor="author" className="required-field">Author</label>
            <input required name="author" title="An author is required"/>
        <button id="add-book">Add Book</button>
        </div>
    </form>
}

export default AddItemContainer;