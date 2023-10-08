import React, { useEffect } from 'react';
import ReactDOM from 'react-dom';

function RowItem(props) {

    useEffect(() => {
    }, []);

    return <tr className="row-item">
        <td>{props.book.title}</td>
        <td>{props.book.author}</td>
        <td>
            <button onClick={() => props.handleDeleteBook(props.book.id)}>Delete</button>
        </td>
    </tr>
}

export default RowItem;