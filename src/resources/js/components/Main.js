import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import AddItemContainer from './AddItemContainer';
import SearchContainer from './SearchContainer';
import RowItem from './RowItem';

function Main() {
    const [books, setBooks] = useState(null);
    const [query, setQuery] = useState("");
    const [sortBy, setSoryBy] = useState(["", ""]);

    useEffect(() => {
        async function prepare() {
            let res = await fetch("/api/books");
            if(res.status === 200) {
                let json = await res.json();
                setBooks(json.data);
            }
        }

        prepare();
    }, []);

    useEffect(() => {
        throttle(async () => {
            let res = await fetch("/api/books/search/" + query + sortBy[0] + "/" + sortBy[1]);
            let json = await res.json();
            setBooks(json?.data);
        }, 1000)();
    }, [query, sortBy]);


    function throttle(func, delay) {
        let timer;
        return function(...args) {
           clearTimeout(timer);
           timer = setTimeout(() => func.apply(this, args), delay);
        }
     }

    async function handleAddBook(book) {
        let res = await fetch("/api/books/add", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(book)
        });
        if(res.status === 200) {
            let json = await res.json();
            setBooks([json.data].concat(...books));
        }
    }

    async function handleDeleteBook(id) {
        let res = await fetch("/api/books/" + id, {
            method: "delete",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        });
        if(res.status === 200) {
            let json = await res.json();
            console.log(json);
            setBooks([...books].filter(b => b.id !== id));
        }
    }

    async function handleSearchChange(e) {
        setQuery(e.target.value);
    }

    function handleSortChange(e) {
        let val = e.target.value.split(", ");
        setSoryBy([val[0].toLowerCase(), val[1]])
    }


    return <div>
        <AddItemContainer handleAddBook={handleAddBook}/>
        <SearchContainer handleSearchChange={handleSearchChange} handleSortChange={handleSortChange} />
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {books ? books.map(b => <RowItem key={b.title+"_"+b.author} book={b} handleDeleteBook={handleDeleteBook} />) : null}
            </tbody>
        </table>
    </div>;
}

export default Main;

if (document.getElementById('root')) {
    ReactDOM.render(<Main />, document.getElementById('root'));
}