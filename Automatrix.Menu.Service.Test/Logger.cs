﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace Automatrix.Menu.Service.Test
{
    public static class Logger
    {
        private static log4net.ILog Log { get; set; }

        static Logger()
        {
            Log = log4net.LogManager.GetLogger(typeof(Logger));
        }

        public static void Error(object msg)
        {
            Log.Error(msg);
        }

        public static void Error(object msg, Exception ex)
        {
            Log.Error(msg, ex);
        }

        public static void Error(Exception ex)
        {
            Log.Error(ex.Message, ex);
        }

        public static void Info(object msg)
        {
            Log.Info(msg);
        }

        public static void Debug(Object msg)
        {
            Log.Debug(msg);
        }

        public static void Debug(Object msg, Exception ex)
        {
            Log.Debug(msg, ex);
        }
    }
}