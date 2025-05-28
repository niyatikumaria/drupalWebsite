/**
 * @file
 * Custom JavaScript for rendering Chart.js graphs in Drupal.
 */

(function ($, Drupal, drupalSettings, once) {
  'use strict';

  // Debug flag - set to false for production
  const DEBUG = true;
  
  /**
   * Generate colors for chart datasets based on content type counts
   */
  const generateColors = (count) => {
    const colors = [];
    const baseColors = [
      'rgba(75, 192, 192, 0.6)',
      'rgba(54, 162, 235, 0.6)',
      'rgba(255, 99, 132, 0.6)',
      'rgba(255, 159, 64, 0.6)',
      'rgba(153, 102, 255, 0.6)',
      'rgba(201, 203, 207, 0.6)',
      'rgba(255, 205, 86, 0.6)'
    ];
    
    // Cycle through base colors if we need more than available
    for (let i = 0; i < count; i++) {
      colors.push(baseColors[i % baseColors.length]);
    }
    return colors;
  };

  /**
   * Chart configuration factory
   */
  const getChartConfig = (data, chartType) => {
    const isPieChart = chartType === 'pie' || chartType === 'doughnut';
    const backgroundColors = generateColors(data.data.length);
    
    return {
      type: chartType,
      data: {
        labels: data.labels,
        datasets: [{
          label: 'Content Type Counts',
          data: data.data,
          backgroundColor: backgroundColors,
          borderColor: backgroundColors.map(c => c.replace('0.6', '1')),
          borderWidth: 1,
          hoverOffset: isPieChart ? 10 : 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return `${context.dataset.label}: ${context.raw}`;
              }
            }
          },
          title: {
            display: true,
            text: 'Content Type Distribution',
            font: {
              size: 16
            }
          }
        },
        scales: isPieChart ? {} : {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of Nodes'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Content Types'
            }
          }
        }
      }
    };
  };

  /**
   * Drupal behavior for chart initialization
   */
  Drupal.behaviors.graphInputChart = {
    attach: function(context, settings) {
      if (DEBUG) console.log('[Chart] Behavior triggered', context);
      
      // Check for required settings
      if (!drupalSettings.graph_input?.data) {
        if (DEBUG) console.warn('[Chart] No data found in drupalSettings');
        return;
      }

      // Find canvas elements using once()
      const canvases = once('chart-init', '#myChart', context);
      
      if (canvases.length === 0) {
        if (DEBUG) console.warn('[Chart] Canvas element not found in context', context);
        return;
      }

      // Get chart data and type
      const chartData = drupalSettings.graph_input.data;
      const chartType = drupalSettings.graph_input.chartType || 'bar';
      
      if (DEBUG) console.log('[Chart] Initializing with:', { chartData, chartType });

      // Process each canvas found
      canvases.forEach((canvas) => {
        // Clean up previous chart instance if exists
        if (canvas.chart) {
          if (DEBUG) console.log('[Chart] Destroying previous chart instance');
          canvas.chart.destroy();
        }

        // Initialize new chart
        try {
          const config = getChartConfig(chartData, chartType);
          canvas.chart = new Chart(canvas, config);
          
          if (DEBUG) console.log('[Chart] Successfully initialized', canvas.chart);
          
          // Add resize observer for responsive behavior
          new ResizeObserver(() => {
            canvas.chart.resize();
          }).observe(canvas.parentElement);
          
        } catch (error) {
          console.error('[Chart] Initialization failed:', error);
        }
      });
    },
    
    // Clean up when elements are removed
    detach: function(context, settings, trigger) {
      if (trigger === 'unload') {
        const canvases = once.remove('chart-init', '#myChart', context);
        canvases.forEach((canvas) => {
          if (canvas.chart) {
            canvas.chart.destroy();
            delete canvas.chart;
          }
        });
      }
    }
  };

})(jQuery, Drupal, drupalSettings, once);