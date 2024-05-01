
import { useEffect, useState } from "react";
import { useSelector, useDispatch } from "react-redux";
import { useNavigate } from 'react-router-dom';
import classNames from "classnames/bind";
import { Bar } from "react-chartjs-2";

import { getReportYears } from "~/services";
import { createAxios } from '~/utils';
import { userSelector, loginSuccess } from '~/store';
import Chart from "chart.js/auto";
import { CategoryScale } from "chart.js";
import style from './ReportYears.module.scss'

Chart.register(CategoryScale);
const cx = classNames.bind(style);

function ReportYears() {
  const navigate = useNavigate();
  const dispatch = useDispatch();

  const [data, setData] = useState(null);
  const user = useSelector(userSelector);
  const token = user?.access_token;
  const requestJWT = createAxios(user, dispatch, loginSuccess);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const res = await getReportYears(token, requestJWT);
        if (res?.message || res?.errros)
          return navigate('/500-ServerError');
        const dataFormated = {
          labels: Object.keys(res?.data),
          datasets: [
            {
              label: "Tổng số học sinh trúng tuyển",
              data: Object.keys(res?.data).map((key) => res?.data[key]),
              backgroundColor: 'rgba(86, 136, 193, 1)'
            }
          ]
        }
        setData(dataFormated);
      } catch (error) {
        navigate('/500-ServerError');
      }
    }
    fetchData();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  if (data) {

  }
  return (
    <div className={cx('wrapper')}>
      <div className={cx('report_major')}>
        {data &&
          <Bar
            className={cx('bar-chart')}
            data={data}
            options={{
              plugins: {
                legend: {
                  display: true,
                  align: 'end'
                },
              },
              scales: {
                x: {
                  title: {
                    display: true,
                    text: 'Năm học',
                    align: 'end',
                    font: {
                      size: 16
                    }
                  },
                  grid: {
                    display: false
                  }
                },
                y: {
                  title: {
                    display: true,
                    text: 'Tổng số',
                    align: 'end',
                    font: {
                      size: 16
                    }
                  },
                  ticks: {
                    stepSize: 10, // Bước nhảy giá trị trục y là 10
                  },
                  grid: {
                    display: false
                  }
                }
              },
              font: {
                family: 'Roboto',
                size: 14
              }
            }}
          />
        }
      </div>
      <p className={cx('title-report')}>
        Báo cáo, thống kê số sinh viên trúng tuyển trong 5 năm gần đây
      </p>
    </div>
  );
}

export default ReportYears;