import React, { useEffect, useState } from 'react';
import "../../sass/addItemContainer.scss";

function AddItemContainer(props) {
    const [books, setBooks] = useState([]);

    function handleSubmit(e) {
        e.preventDefault();
        props.handleAddBook({title: e.target.title.value, author: e.target.author.value});
    }

    useEffect(() => {
    }, []);

    return <form onSubmit={handleSubmit}>
        <div id="fields">
            <div className="input-container">
                <label htmlFor="title">Title</label>
                <input required name="title" title="A title is required" onChange={() => props.setMessage(null)}/>
            </div>
            <div className="input-container">
                <label htmlFor="author">Author</label>
                <input required name="author" title="An author is required" onChange={() => props.setMessage(null)}/>
            </div>
        </div>
        <button id="add-book">Add Book</button>
    </form>
}

export default AddItemContainer;