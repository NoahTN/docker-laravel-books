import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import '../../sass/rowItem.scss';

function RowItem(props) {
    const [author, setAuthor] = useState(props.book.author);
    const [editMode, setEditMode] = useState(false);

    function handleEditMode(e) {
        setEditMode(true);
    }

    function handleAuthorInput(e) {
        setAuthor(e.target.value);
    }

    function handleUpdateAuthor() {
        props.handleUpdateAuthor(props.book.id, author);
        setEditMode(false);
    }

    return <tr className="row-item">
        <td>{props.book.title}</td>
        <td>{editMode ? <span className="column-author">
                <input name={"edit-" + props.book.title + "_" + props.book.author} defaultValue={props.book.author} onChange={handleAuthorInput} />
                <button className="change-button" onClick={handleUpdateAuthor}>Save</button>
            </span> : <span className="column-author">
                {props.book.author}
                <button  className="change-button" onClick={handleEditMode}>Edit</button>
            </span>}
        </td>
        <td>
            <button onClick={() => props.handleDeleteBook(props.book.id)}>Delete</button>
        </td>
    </tr>
}

export default RowItem;