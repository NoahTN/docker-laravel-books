import React, { useEffect, useRef, useState } from 'react';

import '../../sass/exportContainer.scss';

function ExportContainer(props) {
    const [columns, setColumns] = useState(["title", "author"]);
    const [data, setData] = useState(null);
    const format = useRef(null);
    

    function handleSelectChange(e) {
        let map = {
            "title+author": ["title", "author"],
            "title": ["title"],
            "author": ["author"]
        }

        setColumns(map[e.target.value]);
    }

    async function handleExportCSV() {
        let res = await fetch("/api/books/export?format=csv" + columns.map(c => "&columns[]=" + c).join("") , {
            method:"get",
            headers: {
                'Content-Type': 'application/json',
            },
        });
        let text = await(res.text());
        console.log(text);
        format.current = "csv";
        setData(text);
    }

    async function handleExportXML() {
        let res = await fetch("/api/books/export?format=xml" + columns.map(c => "&columns[]=" + c).join("") , {
            method:"get",
            headers: {
                'Content-Type': 'application/json',
            },
        });
        let text = await(res.text());
        console.log(text);
        format.current = "xml";
        setData(text);
    }

    return <div id="export-container">
        <select name="exportColumns" onChange={handleSelectChange}>
            <option value="title+author">Title and Author</option>
            <option value="title">Title Only</option>
            <option value="author">Author Only</option>
        </select>
        <button onClick={handleExportCSV}>CSV</button>
        <button onClick={handleExportXML}>XML</button>
        {data ? <a href={'data:text/' + format.current + ";charset=utf-8," + encodeURI(data)} download={"books." + format.current}>Download</a> : null}
    </div>
}

export default ExportContainer;