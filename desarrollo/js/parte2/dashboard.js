function mostrarGraficaDashBoard()
{

    c3.generate({
      bindto: '#donut_g1',
      data: {
        columns: [
          [ 'data1', 79 ],
          [ 'data2', 91 ],
          [ 'data3', 71 ],
          [ 'data4', 85 ],
          [ 'data5', 57 ]
        ],
        type : 'donut',
      },
      donut: { title: 'Tiempos muertos' },
    });


    c3.generate({
        bindto: '#donut_g2',
        data: {
          columns: [
            [ 'data1', 79 ],
            [ 'data2', 91 ],
            [ 'data3', 71 ],
            [ 'data4', 85 ],
            [ 'data5', 57 ]
          ],
          type : 'donut',
        },
        donut: { title: 'Tiempos muertos' },
      });

      c3.generate({
        bindto: '#donut_g3',
        data: {
          columns: [
            [ 'data1', 79 ],
            [ 'data2', 91 ],
            [ 'data3', 71 ],
            [ 'data4', 85 ],
            [ 'data5', 57 ]
          ],
          type : 'donut',
        },
        donut: { title: 'Tiempos muertos' },
      });

      c3.generate({
        bindto: '#bar_g4',
        color: { pattern: [ '#FF5722', '#4CAF50' ] },
        data: {
          columns: [
            [ 'data1', 492, 118, 124, 332, 262, 182 ],
            [ 'data2', 205, 138, 164, 474, 244, 216 ]
          ],
          type: 'bar',
        },
        bar: {
          width: { ratio: 0.5 },
        },
      });

      c3.generate({
        bindto: '#bar_g5',
        color: { pattern: [ '#FF5722', '#4CAF50' ] },
        data: {
          columns: [
            [ 'data1', 492, 118, 124, 332, 262, 182 ],
            [ 'data2', 205, 138, 164, 474, 244, 216 ]
          ],
          type: 'bar',
        },
        bar: {
          width: { ratio: 0.5 },
        },
      });

    
}