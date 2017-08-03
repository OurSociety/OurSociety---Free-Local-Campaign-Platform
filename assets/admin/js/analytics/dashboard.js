import './active-users'
import moment from 'moment'
import Chart from 'chart.js'

// noinspection SpellCheckingInspection
const CLIENT_ID = '296423700021-j2uidh1dnbjrpkje9e9gnomt7bm7ag3l.apps.googleusercontent.com';

if (typeof gapi !== "undefined") {

  gapi.analytics.ready(function () {

    /**
     * Authorize the user immediately if the user has already granted access.
     * If no access has been created, render an authorize button inside the
     * element with the ID "embed-api-auth-container".
     */
    gapi.analytics.auth.authorize({
      container: 'embed-api-auth-container',
      clientid: CLIENT_ID
    });

    /**
     * Create a new DataChart instance with the given query parameters
     * and Google chart options. It will be rendered inside an element
     * with the id "chart-container".
     */
    let dataChart = new gapi.analytics.googleCharts.DataChart({
      query: {
        ids: "ga:156148947",
        metrics: 'ga:sessions',
        dimensions: 'ga:date',
        'start-date': '30daysAgo',
        'end-date': 'yesterday'
      },
      chart: {
        container: 'chart-container',
        type: 'LINE',
        options: {
          title: 'Active Sessions',
          width: '100%'
        }
      }
    });

    let dataChart1 = new gapi.analytics.googleCharts.DataChart({
      query: {
        ids: "ga:156148947",
        metrics: 'ga:sessions',
        dimensions: 'ga:region',
        'start-date': '30daysAgo',
        'end-date': 'yesterday',
        'max-results': 6,
        sort: '-ga:sessions'
      },
      chart: {
        container: 'chart-1-container',
        type: 'PIE',
        options: {
          title: 'Top Regions',
          width: '100%',
          pieHole: 4 / 9
        }
      }
    });


    /**
     * Create the second DataChart for top countries over the past 30 days.
     * It will be rendered inside an element with the id "chart-2-container".
     */
    let dataChart2 = new gapi.analytics.googleCharts.DataChart({
      query: {
        ids: "ga:156148947",
        metrics: 'ga:sessions',
        dimensions: 'ga:region',
        'start-date': '30daysAgo',
        'end-date': 'yesterday',
        'max-results': 6,
        sort: '-ga:sessions'
      },
      chart: {
        container: 'chart-2-container',
        type: 'PIE',
        options: {
          width: '100%',
          pieHole: 4 / 9
        }
      }
    });


    dataChart.execute();
    dataChart1.execute();
    dataChart2.execute();
    renderWeekOverWeekChart("ga:156148947");
    renderYearOverYearChart("ga:156148947");
    // renderTopBrowsersChart(data.ids);
    // renderTopCountriesChart(data.ids);


    let activeUsers = new gapi.analytics.ext.ActiveUsers({
      ids: "ga:156148947",
      container: 'active-users-container',
      pollingInterval: 5
    });


    /**
     * Add CSS animation to visually show the when users come and go.
     */
    activeUsers.once('success', function () {
      // let element = this.container.firstChild;
      let timeout;

      this.on('change', function (data) {
        let element = this.container.firstChild;
        let animationClass = data.delta > 0 ? 'is-increasing' : 'is-decreasing';
        element.className += (' ' + animationClass);

        clearTimeout(timeout);
        timeout = setTimeout(function () {
          element.className =
            element.className.replace(/ is-(increasing|decreasing)/g, '');
        }, 3000);
      });
    });

    /**
     * Extend the Embed APIs `gapi.analytics.report.Data` component to
     * return a promise the is fulfilled with the value returned by the API.
     * @param {Object} params The request parameters.
     * @return {Promise} A promise.
     */
    function query(params) {
      return new Promise(function (resolve, reject) {
        let data = new gapi.analytics.report.Data({query: params});
        data.once('success', function (response) {
          resolve(response);
        })
          .once('error', function (response) {
            reject(response);
          })
          .execute();
      });
    }

    /**
     * Draw the a chart.js line chart with data from the specified view that
     * overlays session data for the current week over session data for the
     * previous week.
     */
    function renderWeekOverWeekChart(ids) {

      // Adjust `now` to experiment with different days, for testing only...
      let now = moment(); // .subtract(3, 'day');

      let thisWeek = query({
        'ids': ids,
        'dimensions': 'ga:date,ga:nthDay',
        'metrics': 'ga:sessions',
        'start-date': moment(now).subtract(1, 'day').day(0).format('YYYY-MM-DD'),
        'end-date': moment(now).format('YYYY-MM-DD')
      });

      let lastWeek = query({
        'ids': ids,
        'dimensions': 'ga:date,ga:nthDay',
        'metrics': 'ga:sessions',
        'start-date': moment(now).subtract(1, 'day').day(0).subtract(1, 'week')
          .format('YYYY-MM-DD'),
        'end-date': moment(now).subtract(1, 'day').day(6).subtract(1, 'week')
          .format('YYYY-MM-DD')
      });

      Promise.all([thisWeek, lastWeek]).then(function (results) {

        let data1 = results[0].rows.map(function (row) {
          return +row[2];
        });
        let data2 = results[1].rows.map(function (row) {
          return +row[2];
        });
        let labels = results[1].rows.map(function (row) {
          return +row[0];
        });

        labels = labels.map(function (label) {
          return moment(label, 'YYYYMMDD').format('ddd');
        });

        let data = {
          labels: labels,
          datasets: [
            {
              label: 'Last Week',
              fillColor: 'rgba(220,220,220,0.5)',
              strokeColor: 'rgba(220,220,220,1)',
              pointColor: 'rgba(220,220,220,1)',
              pointStrokeColor: '#fff',
              data: data2
            },
            {
              label: 'This Week',
              fillColor: 'rgba(151,187,205,0.5)',
              strokeColor: 'rgba(151,187,205,1)',
              pointColor: 'rgba(151,187,205,1)',
              pointStrokeColor: '#fff',
              data: data1
            }
          ]
        };

        new Chart(makeCanvas('chart-1-container')).Line(data);
        generateLegend('legend-1-container', data.datasets);
      });
    }


    /**
     * Create a new canvas inside the specified element. Set it to be the width
     * and height of its container.
     * @param {string} id The id attribute of the element to host the canvas.
     * @return {RenderingContext} The 2D canvas context.
     */
    function makeCanvas(id) {
      let container = document.getElementById(id);
      let canvas = document.createElement('canvas');
      let ctx = canvas.getContext('2d');

      container.innerHTML = '';
      canvas.width = container.offsetWidth;
      canvas.height = container.offsetHeight;
      container.appendChild(canvas);

      return ctx;
    }

    /**
     * Draw the a chart.js bar chart with data from the specified view that
     * overlays session data for the current year over session data for the
     * previous year, grouped by month.
     */
    function renderYearOverYearChart(ids) {

      // Adjust `now` to experiment with different days, for testing only...
      let now = moment(); // .subtract(3, 'day');

      let thisYear = query({
        'ids': ids,
        'dimensions': 'ga:month,ga:nthMonth',
        'metrics': 'ga:users',
        'start-date': moment(now).date(1).month(0).format('YYYY-MM-DD'),
        'end-date': moment(now).format('YYYY-MM-DD')
      });

      let lastYear = query({
        'ids': ids,
        'dimensions': 'ga:month,ga:nthMonth',
        'metrics': 'ga:users',
        'start-date': moment(now).subtract(1, 'year').date(1).month(0)
          .format('YYYY-MM-DD'),
        'end-date': moment(now).date(1).month(0).subtract(1, 'day')
          .format('YYYY-MM-DD')
      });

      Promise.all([thisYear, lastYear]).then(function (results) {
        let data1 = results[0].rows.map(function (row) {
          return +row[2];
        });
        let data2 = results[1].rows.map(function (row) {
          return +row[2];
        });
        let labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
          'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Ensure the data arrays are at least as long as the labels array.
        // Chart.js bar charts don't (yet) accept sparse datasets.
        for (let i = 0, len = labels.length; i < len; i++) {
          if (data1[i] === undefined) data1[i] = null;
          if (data2[i] === undefined) data2[i] = null;
        }

        let data = {
          labels: labels,
          datasets: [
            {
              label: 'Last Year',
              fillColor: 'rgba(220,220,220,0.5)',
              strokeColor: 'rgba(220,220,220,1)',
              data: data2
            },
            {
              label: 'This Year',
              fillColor: 'rgba(151,187,205,0.5)',
              strokeColor: 'rgba(151,187,205,1)',
              data: data1
            }
          ]
        };

        new Chart(makeCanvas('chart-2-container')).Bar(data);
        generateLegend('legend-2-container', data.datasets);
      })
        .catch(function (err) {
          console.error(err.stack);
        });
    }

    activeUsers.execute();
  });
}
