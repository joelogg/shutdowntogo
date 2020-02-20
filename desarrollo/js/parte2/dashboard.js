function mostrarGraficaDashBoard()
{

    c3.generate(
    {
        bindto: '#gauge_g1',
        data: 
        {
            columns: 
            [
                ['Finalizdo/Total', 67]
            ],
            type: 'gauge'
        },
        color: 
        {
            //pattern: ['#2222AA']
        }
    });
    

    c3.generate(
    {
        bindto: '#donut_g2',
        data: 
        {
            columns: 
            [
                [ 'Abiertas', 12 ],
                [ 'En progreso', 4 ],
                [ 'Finalizadas', 9 ],
                [ 'Atrazadas', 3 ],
                [ 'Reprogramadas', 7 ]
            ],
            type : 'donut',
            onclick: function (d, i) { console.log("onclick", d, i); },
            //onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            //onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
        donut: { title: '35 OT' },
    });


    c3.generate(
    {
        bindto: '#bar_g3',
        data: 
        {
            x : 'x',
            columns: 
            [
                ['x', 'Muy alta', 'Alta', 'Media', 'Baja'],
                [ 'Abiertas', 118, 124, 332, 262 ],
                [ 'En progreso', 118, 124, 332, 262 ],
                [ 'Finalizadas', 118, 124, 332, 262 ],
                [ 'Atrazadas', 118, 124, 332, 262 ],
                [ 'Reprogramadas', 138, 164, 474, 244 ]
            ],
            type: 'bar',
            groups: 
            [
                ['Abiertas','En progreso', 'Finalizadas', 'Atrazadas', 'Reprogramadas']
            ],
        },
        bar: 
        {
            width: { ratio: 0.5 },
        },
        axis: 
        {
            rotated: true,
            x: 
            {
                type: 'category',
                tick: 
                {
                    multiline: true
                }
            },
        }
    });

    c3.generate(
        {
            bindto: '#bar_g4',
            data: 
            {
                x : 'x',
                columns: 
                [
                    ['x', 'Area1', 'Area2', 'Area3', 'Area4'],
                    [ 'Abiertas', 118, 124, 332, 262 ],
                    [ 'En progreso', 118, 124, 332, 262 ],
                    [ 'Finalizadas', 118, 124, 332, 262 ],
                    [ 'Atrazadas', 118, 124, 332, 262 ],
                    [ 'Reprogramadas', 138, 164, 474, 244 ]
                ],
                type: 'bar',
                groups: 
                [
                    ['Abiertas','En progreso', 'Finalizadas', 'Atrazadas', 'Reprogramadas']
                ],
            },
            bar: 
            {
                width: { ratio: 0.5 },
            },
            axis: 
            {
                x: 
                {
                    type: 'category',
                    tick: 
                    {
                        multiline: true
                    }
                },
            }
        });

    
}



/*
chart.load({
        columns: [
            ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2],
            ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
            ["virginica", 2.5, 1.9, 2.1, 1.8, 2.2, 2.1, 1.7, 1.8, 1.8, 2.5, 2.0, 1.9, 2.1, 2.0, 2.4, 2.3, 1.8, 2.2, 2.3, 1.5, 2.3, 2.0, 2.0, 1.8, 2.1, 1.8, 1.8, 1.8, 2.1, 1.6, 1.9, 2.0, 2.2, 1.5, 1.4, 2.3, 2.4, 1.8, 1.8, 2.1, 2.4, 2.3, 1.9, 2.3, 2.5, 2.3, 1.9, 2.0, 2.3, 1.8],
        ]
    });


chart.unload({
        ids: 'data1'
    });
*/